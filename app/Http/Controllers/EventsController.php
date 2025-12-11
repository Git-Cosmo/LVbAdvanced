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
            $query->orderBy('start_date', 'desc');
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
        // Increment views count
        $event->increment('views_count');

        // Get related events (same type or game)
        $relatedEvents = Event::published()
            ->where('id', '!=', $event->id)
            ->where(function ($query) use ($event) {
                $query->where('event_type', $event->event_type)
                    ->orWhere('game_name', $event->game_name);
            })
            ->limit(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }
}
