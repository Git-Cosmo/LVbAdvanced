<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\EventsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventsManagementController extends Controller
{
    /**
     * Display events management page.
     */
    public function index(): View
    {
        $events = Event::orderBy('start_date', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Event::count(),
            'upcoming' => Event::upcoming()->count(),
            'ongoing' => Event::ongoing()->count(),
            'featured' => Event::featured()->count(),
        ];

        return view('admin.events.index', compact('events', 'stats'));
    }

    /**
     * Manually trigger events import.
     */
    public function import(EventsService $eventsService): RedirectResponse
    {
        try {
            $results = $eventsService->scrapeEvents();

            $message = sprintf(
                'Events imported successfully! Success: %d, Skipped: %d, Errors: %d',
                $results['success'],
                $results['skipped'],
                $results['errors']
            );

            return redirect()->route('admin.events.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.events.index')
                ->with('error', 'Failed to import events: ' . $e->getMessage());
        }
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Event $event): RedirectResponse
    {
        $event->update(['is_featured' => !$event->is_featured]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event featured status updated!');
    }

    /**
     * Toggle published status.
     */
    public function togglePublished(Event $event): RedirectResponse
    {
        $event->update(['is_published' => !$event->is_published]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event published status updated!');
    }

    /**
     * Delete an event.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }
}
