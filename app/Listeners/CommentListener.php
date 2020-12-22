<?php

namespace App\Listeners;

use App\Notifications\CommentNotification;
use App\Post;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $postComentario = Post::where('id', $event->comentario->post_id)->first();
        $user = User::where('id', $postComentario->user_id)->first();
        $user->notify(new CommentNotification($event->comentario));
    }
}
