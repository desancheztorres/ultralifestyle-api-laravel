<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Post;
use App\Models\Like;

class PostLikeController extends Controller
{
    public function store(Request $request, Blog $blog, Post $post) {

        $this->authorize('like', $post);

        if($request->user()->hasLikedPost($post)) {
            return response(null, 409);
        }

        $like = new Like;
        $like->user()->associate($request->user());

        $post->likes()->save($like);

        return response(null, 204);
    }
}
