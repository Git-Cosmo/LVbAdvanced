<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentParticipant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TournamentManagementController extends Controller
{
    public function index(): View
    {
        $tournaments = Tournament::with(['organizer', 'participants'])
            ->latest()
            ->paginate(20);

        return view('admin.tournaments.index', compact('tournaments'));
    }

    public function show(Tournament $tournament): View
    {
        $tournament->load([
            'organizer',
            'participants.user',
            'matches',
            'staff.user',
        ]);

        return view('admin.tournaments.show', compact('tournament'));
    }

    public function approveParticipant(TournamentParticipant $participant): RedirectResponse
    {
        $participant->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $participant->tournament->incrementParticipants();

        return back()->with('success', 'Participant approved successfully.');
    }

    public function rejectParticipant(TournamentParticipant $participant): RedirectResponse
    {
        $participant->update(['status' => 'rejected']);

        return back()->with('success', 'Participant rejected.');
    }

    public function generateBrackets(Tournament $tournament): RedirectResponse
    {
        if ($tournament->status !== 'registration_closed' && $tournament->status !== 'upcoming') {
            return back()->with('error', 'Brackets can only be generated for tournaments with closed registration.');
        }

        // Get all checked-in or approved participants
        $participants = $tournament->participants()
            ->whereIn('status', ['checked_in', 'approved'])
            ->get();

        if ($participants->count() < 2) {
            return back()->with('error', 'Need at least 2 participants to generate brackets.');
        }

        // Generate brackets based on format
        switch ($tournament->format) {
            case 'single_elimination':
                $this->generateSingleEliminationBracket($tournament, $participants);
                break;
            case 'double_elimination':
                $this->generateDoubleEliminationBracket($tournament, $participants);
                break;
            case 'round_robin':
                $this->generateRoundRobinBracket($tournament, $participants);
                break;
            case 'swiss':
                $this->generateSwissBracket($tournament, $participants);
                break;
        }

        $tournament->update(['status' => 'in_progress']);

        return back()->with('success', 'Brackets generated successfully!');
    }

    protected function generateSingleEliminationBracket(Tournament $tournament, $participants)
    {
        $participantCount = $participants->count();

        // Calculate number of rounds needed
        $rounds = ceil(log($participantCount, 2));

        // Seed participants
        $participants = $participants->shuffle();
        foreach ($participants as $index => $participant) {
            $participant->update(['seed' => $index + 1]);
        }

        // Create first round matches
        $round = 1;
        $matchNumber = 1;

        for ($i = 0; $i < $participantCount; $i += 2) {
            $participant1 = $participants[$i] ?? null;
            $participant2 = $participants[$i + 1] ?? null;

            TournamentMatch::create([
                'tournament_id' => $tournament->id,
                'round' => $round,
                'match_number' => $matchNumber++,
                'participant1_id' => $participant1?->id,
                'participant2_id' => $participant2?->id,
                'status' => ($participant1 && $participant2) ? 'ready' : 'pending',
            ]);
        }

        // Create placeholder matches for subsequent rounds
        $matchesInRound = ceil($participantCount / 2);
        for ($r = 2; $r <= $rounds; $r++) {
            $matchesInRound = ceil($matchesInRound / 2);
            for ($m = 1; $m <= $matchesInRound; $m++) {
                TournamentMatch::create([
                    'tournament_id' => $tournament->id,
                    'round' => $r,
                    'match_number' => $m,
                    'status' => 'pending',
                ]);
            }
        }
    }

    protected function generateDoubleEliminationBracket(Tournament $tournament, $participants)
    {
        // Simplified double elimination - create winners and losers brackets
        $this->generateSingleEliminationBracket($tournament, $participants);

        // Additional logic for losers bracket would go here
        // This is a complex algorithm that would need more implementation
    }

    protected function generateRoundRobinBracket(Tournament $tournament, $participants)
    {
        $count = $participants->count();
        $participants = $participants->values();

        $round = 1;
        $matchNumber = 1;

        // Each participant plays every other participant
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                TournamentMatch::create([
                    'tournament_id' => $tournament->id,
                    'round' => $round,
                    'match_number' => $matchNumber++,
                    'participant1_id' => $participants[$i]->id,
                    'participant2_id' => $participants[$j]->id,
                    'status' => 'ready',
                ]);
            }
        }
    }

    protected function generateSwissBracket(Tournament $tournament, $participants)
    {
        // Swiss system: pair participants with similar records
        // For the first round, pair randomly
        $participants = $participants->shuffle()->values();

        $matchNumber = 1;
        for ($i = 0; $i < $participants->count(); $i += 2) {
            if (isset($participants[$i + 1])) {
                TournamentMatch::create([
                    'tournament_id' => $tournament->id,
                    'round' => 1,
                    'match_number' => $matchNumber++,
                    'participant1_id' => $participants[$i]->id,
                    'participant2_id' => $participants[$i + 1]->id,
                    'status' => 'ready',
                ]);
            }
        }
    }

    public function updateMatchResult(Request $request, TournamentMatch $match): RedirectResponse
    {
        $validated = $request->validate([
            'participant1_score' => 'required|integer|min:0',
            'participant2_score' => 'required|integer|min:0',
        ]);

        // Determine winner, handle ties
        $winner_id = null;
        if ($validated['participant1_score'] > $validated['participant2_score']) {
            $winner_id = $match->participant1_id;
        } elseif ($validated['participant2_score'] > $validated['participant1_score']) {
            $winner_id = $match->participant2_id;
        }
        // If scores are equal, winner_id remains null (tie/needs resolution)

        $match->update([
            'participant1_score' => $validated['participant1_score'],
            'participant2_score' => $validated['participant2_score'],
            'winner_id' => $winner_id,
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Advance winner to next round if single elimination
        if ($match->tournament->format === 'single_elimination') {
            $this->advanceWinner($match);
        }

        return back()->with('success', 'Match result updated successfully.');
    }

    protected function advanceWinner(TournamentMatch $match)
    {
        $nextRound = $match->round + 1;
        $nextMatchNumber = ceil($match->match_number / 2);

        $nextMatch = TournamentMatch::where('tournament_id', $match->tournament_id)
            ->where('round', $nextRound)
            ->where('match_number', $nextMatchNumber)
            ->first();

        if ($nextMatch) {
            // Determine if winner goes to participant1 or participant2 slot
            $isOddMatch = ($match->match_number % 2) === 1;

            if ($isOddMatch) {
                $nextMatch->update(['participant1_id' => $match->winner_id]);
            } else {
                $nextMatch->update(['participant2_id' => $match->winner_id]);
            }

            // Check if match is now ready
            if ($nextMatch->participant1_id && $nextMatch->participant2_id) {
                $nextMatch->update(['status' => 'ready']);
            }
        }
    }
}
