<?php

namespace App\Listeners;

use App\Notifications\LikeNotification;
use App\Post;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LikeListener
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

        $postLike = Post::where('id', $event->like->likeable_id)->first();
        $user = User::where('id', $postLike->user_id)->first();
        $user->notify(new LikeNotification($event->like));
    }
}
