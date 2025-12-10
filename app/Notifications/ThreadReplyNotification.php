<?php

namespace App\Notifications;

use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ThreadReplyNotification extends Notification
{
    use Queueable;

    protected ForumPost $post;
    protected ForumThread $thread;

    /**
     * Create a new notification instance.
     */
    public function __construct(ForumPost $post, ForumThread $thread)
    {
        $this->post = $post;
        $this->thread = $thread;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'thread_reply',
            'title' => 'New reply to your thread',
            'message' => $this->post->user->name . ' replied to your thread "' . $this->thread->title . '"',
            'url' => route('forum.thread.show', $this->thread->slug) . '#post-' . $this->post->id,
            'user_id' => $this->post->user_id,
            'user_name' => $this->post->user->name,
            'thread_id' => $this->thread->id,
            'thread_title' => $this->thread->title,
            'post_id' => $this->post->id,
        ];
    }
}
