<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Blog $blog)
    {
        return $user->ownsBlog($blog);
    }

    public function destroy(User $user, Blog $blog)
    {
        return $user->ownsBlog($blog);
    }
}
