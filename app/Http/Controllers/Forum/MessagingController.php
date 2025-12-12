<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\PrivateMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MessagingController extends Controller
{
    /**
     * Display the user's inbox.
     */
    public function inbox(): View
    {
        $conversations = PrivateMessage::where(function ($query) {
            $query->where('sender_id', auth()->id())
                ->orWhere('recipient_id', auth()->id());
        })
            ->select('conversation_id')
            ->distinct()
            ->get()
            ->map(function ($item) {
                $messages = PrivateMessage::where('conversation_id', $item->conversation_id)
                    ->with(['sender', 'recipient'])
                    ->orderByDesc('created_at')
                    ->get();

                $lastMessage = $messages->first();
                $otherUser = $lastMessage->sender_id === auth()->id()
                    ? $lastMessage->recipient
                    : $lastMessage->sender;

                $unreadCount = $messages->where('recipient_id', auth()->id())
                    ->where('is_read', false)
                    ->count();

                return [
                    'conversation_id' => $item->conversation_id,
                    'other_user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'message_count' => $messages->count(),
                ];
            })
            ->sortByDesc('last_message.created_at');

        return view('forum.messaging.inbox', compact('conversations'));
    }

    /**
     * Show a conversation.
     */
    public function conversation(string $conversationId): View
    {
        $messages = PrivateMessage::where('conversation_id', $conversationId)
            ->where(function ($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('recipient_id', auth()->id());
            })
            ->with(['sender', 'recipient', 'attachments'])
            ->orderBy('created_at')
            ->get();

        if ($messages->isEmpty()) {
            abort(404);
        }

        // Mark messages as read
        PrivateMessage::where('conversation_id', $conversationId)
            ->where('recipient_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $otherUser = $messages->first()->sender_id === auth()->id()
            ? $messages->first()->recipient
            : $messages->first()->sender;

        return view('forum.messaging.conversation', compact('messages', 'conversationId', 'otherUser'));
    }

    /**
     * Show form to compose new message.
     */
    public function compose(?User $recipient = null): View
    {
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();

        return view('forum.messaging.compose', compact('recipient', 'users'));
    }

    /**
     * Send a new message.
     */
    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:10000',
            'conversation_id' => 'nullable|string',
        ]);

        $conversationId = $validated['conversation_id'] ?? Str::uuid()->toString();

        $message = PrivateMessage::create([
            'conversation_id' => $conversationId,
            'sender_id' => auth()->id(),
            'recipient_id' => $validated['recipient_id'],
            'message' => $validated['message'],
        ]);

        return redirect()->route('forum.messaging.conversation', $conversationId)
            ->with('success', 'Message sent successfully!');
    }

    /**
     * Delete a message (soft delete).
     */
    public function destroy(PrivateMessage $message): RedirectResponse
    {
        if ($message->sender_id !== auth()->id() && $message->recipient_id !== auth()->id()) {
            abort(403);
        }

        $message->delete();

        return back()->with('success', 'Message deleted.');
    }
}
