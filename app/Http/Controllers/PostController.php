<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Blog;
use App\Transformers\PostTransformer;
use App\Models\Post;

class PostController extends Controller
{
    public function store(StorePostRequest $request, Blog $blog) {
        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $blog->posts()->save($post);

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function update(UpdatePostRequest $request, Blog $blog, Post $post) {

        $this->authorize('update', $post);

        $post->body = $request->get('body', $post->body);
        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function destroy(Blog $blog, Post $post) {
        $this->authorize('destroy', $post);
        $post->delete();

        return response(null, 204);
    }
}
