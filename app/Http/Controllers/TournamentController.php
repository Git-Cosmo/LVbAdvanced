<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentParticipant;
use App\Models\TournamentAnnouncement;
use App\Models\TournamentCheckIn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TournamentController extends Controller
{
    /**
     * Display a listing of tournaments.
     */
    public function index(Request $request): View
    {
        $query = Tournament::with(['organizer', 'participants'])
            ->public()
            ->latest('starts_at');

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'active':
                    $query->active();
                    break;
                case 'completed':
                    $query->completed();
                    break;
            }
        }

        // Filter by game
        if ($request->has('game') && $request->game) {
            $query->where('game', $request->game);
        }

        // Filter by format
        if ($request->has('format') && $request->format) {
            $query->where('format', $request->format);
        }

        $tournaments = $query->paginate(12);
        $featured = Tournament::featured()->public()->upcoming()->take(3)->get();

        return view('tournaments.index', compact('tournaments', 'featured'));
    }

    /**
     * Show the form for creating a new tournament.
     */
    public function create(): View
    {
        $this->authorize('create', Tournament::class);

        return view('tournaments.create');
    }

    /**
     * Store a newly created tournament.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Tournament::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'game' => 'nullable|string|max:255',
            'format' => 'required|in:single_elimination,double_elimination,round_robin,swiss',
            'type' => 'required|in:solo,team',
            'team_size' => 'nullable|integer|min:2|max:32',
            'max_participants' => 'required|integer|min:2|max:512',
            'prize_pool' => 'nullable|numeric|min:0',
            'registration_opens_at' => 'nullable|date',
            'registration_closes_at' => 'nullable|date|after:registration_opens_at',
            'check_in_starts_at' => 'nullable|date',
            'check_in_ends_at' => 'nullable|date|after:check_in_starts_at',
            'starts_at' => 'required|date|after:now',
            'rules' => 'nullable|array',
            'is_public' => 'boolean',
            'requires_approval' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'registration_open';

        $tournament = Tournament::create($validated);

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Tournament created successfully!');
    }

    /**
     * Display the specified tournament.
     */
    public function show(Tournament $tournament): View
    {
        $tournament->load([
            'organizer',
            'participants.user',
            'participants.clan',
            'matches' => function ($query) {
                $query->with(['participant1.user', 'participant2.user', 'winner'])
                    ->orderBy('round')
                    ->orderBy('match_number');
            },
            'announcements.user',
            'staff.user'
        ]);

        $userParticipant = null;
        if (auth()->check()) {
            $userParticipant = $tournament->participants()
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('tournaments.show', compact('tournament', 'userParticipant'));
    }

    /**
     * Show the bracket view.
     */
    public function bracket(Tournament $tournament): View
    {
        $tournament->load([
            'matches' => function ($query) {
                $query->with(['participant1', 'participant2', 'winner'])
                    ->orderBy('round')
                    ->orderBy('match_number');
            }
        ]);

        $rounds = $tournament->matches->groupBy('round');

        return view('tournaments.bracket', compact('tournament', 'rounds'));
    }

    /**
     * Register for a tournament.
     */
    public function register(Request $request, Tournament $tournament): RedirectResponse
    {
        if (!$tournament->canRegister()) {
            return back()->with('error', 'Registration is not available for this tournament.');
        }

        $validated = $request->validate([
            'team_name' => $tournament->type === 'team' ? 'required|string|max:255' : 'nullable',
            'roster' => $tournament->type === 'team' ? 'nullable|array' : 'nullable',
        ]);

        // Check if already registered
        $existing = $tournament->participants()
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already registered for this tournament.');
        }

        $status = $tournament->requires_approval ? 'pending' : 'approved';

        $participant = TournamentParticipant::create([
            'tournament_id' => $tournament->id,
            'user_id' => auth()->id(),
            'team_name' => $validated['team_name'] ?? null,
            'roster' => $validated['roster'] ?? null,
            'status' => $status,
            'registered_at' => now(),
            'approved_at' => $status === 'approved' ? now() : null,
        ]);

        if ($status === 'approved') {
            $tournament->incrementParticipants();
        }

        return back()->with('success', $status === 'approved' 
            ? 'Successfully registered for the tournament!' 
            : 'Registration submitted and pending approval.');
    }

    /**
     * Check in for a tournament.
     */
    public function checkIn(Tournament $tournament): RedirectResponse
    {
        if (!$tournament->canCheckIn()) {
            return back()->with('error', 'Check-in is not available at this time.');
        }

        $participant = $tournament->participants()
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->firstOrFail();

        TournamentCheckIn::create([
            'tournament_id' => $tournament->id,
            'participant_id' => $participant->id,
            'checked_in_at' => now(),
            'ip_address' => request()->ip(),
        ]);

        $participant->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Successfully checked in!');
    }

    /**
     * Post an announcement.
     */
    public function postAnnouncement(Request $request, Tournament $tournament): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $isStaff = $tournament->staff()->where('user_id', auth()->id())->exists() ||
                   $tournament->user_id === auth()->id();

        TournamentAnnouncement::create([
            'tournament_id' => $tournament->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'is_official' => $isStaff,
        ]);

        return back()->with('success', 'Announcement posted!');
    }

    /**
     * Show participants list.
     */
    public function participants(Tournament $tournament): View
    {
        $participants = $tournament->participants()
            ->with(['user', 'clan'])
            ->where('status', '!=', 'rejected')
            ->orderBy('seed')
            ->paginate(50);

        return view('tournaments.participants', compact('tournament', 'participants'));
    }
}
