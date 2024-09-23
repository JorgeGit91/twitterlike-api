<?php

namespace Modules\Comment\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Comment\Entities\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Users can only update/delete their own comments
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id  ? Response::allow()
        : Response::deny('You do not own this comment.');
    }

    public function destroy(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id  ? Response::allow()
        : Response::deny('You do not own this comment.');
    }

}
