<?php

namespace App\Policies;

use App\Like;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    use HandlesAuthorization;


    public function Dislike(User $user, Like $like)
    {
        return $user->id === $like->user_id;
    }

    public function Like(User $user, Like $like)
    {
        return Like::where('likeable_id', $like->likeable_id)->where('user_id', $user->user_id)->count();
    
    }

}
