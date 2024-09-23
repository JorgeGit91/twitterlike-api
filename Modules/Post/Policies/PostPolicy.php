<?php

namespace Modules\Post\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Modules\Post\Entities\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
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
     * Users can only update/delete their own posts
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id  ? Response::allow()
        : Response::deny('You do not own this post.');
    }

    public function destroy(User $user, Post $post)
    {
        return $user->id === $post->user_id  ? Response::allow()
        : Response::deny('You do not own this post.');
    }
}
