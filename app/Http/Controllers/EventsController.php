<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventsController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request): View
    {
        $query = Event::published();

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('event_type', $request->type);
        }

        // Filter by status
        $status = $request->get('status', 'upcoming');

        if ($status === 'upcoming') {
            $query->upcoming();
        } elseif ($status === 'ongoing') {
            $query->ongoing();
        } elseif ($status === 'past') {
            $query->past();
        } else {
            $query->orderBy('start_time', 'desc');
        }

        $events = $query->paginate(12);

        $featuredEvents = Event::published()
            ->featured()
            ->upcoming()
            ->limit(3)
            ->get();

        return view('events.index', compact('events', 'featuredEvents'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event): View
    {
        // Eager load relationships
        $event->load(['venues', 'ticketLinks', 'infoLinks']);

        // Increment views count
        $event->increment('views_count');

        // Get related events (same type)
        $relatedEvents = Event::published()
            ->where('id', '!=', $event->id)
            ->where('event_type', $event->event_type)
            ->limit(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }

    /**
     * RSVP to an event.
     */
    public function rsvp(Request $request, Event $event)
    {
        // Check if event is in the past
        if ($event->isPast()) {
            return back()->with('error', 'Cannot RSVP to past events.');
        }

        $validated = $request->validate([
            'status' => 'required|in:going,interested,not_going',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();

        try {
            // Create or update RSVP
            $event->rsvps()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'status' => $validated['status'],
                    'notes' => $validated['notes'] ?? null,
                ]
            );

            return back()->with('success', 'RSVP updated successfully!');
        } catch (\Exception $e) {
            \Log::error('RSVP Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update RSVP. Please try again.');
        }
    }

    /**
     * Cancel RSVP to an event.
     */
    public function cancelRsvp(Event $event)
    {
        $user = auth()->user();
        
        $event->rsvps()->where('user_id', $user->id)->delete();

        return back()->with('success', 'RSVP cancelled successfully!');
    }
}
