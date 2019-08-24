<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use App\Models\Post;
use App\Transformers\BlogTransformer;

class BlogController extends Controller
{
    public function store(StoreBlogRequest $request) {
        $blog = new Blog;
        $blog->title = $request->title;
        $blog->image = $request->image;
        $blog->description = $request->description;

        $blog->user()->associate($request->user());

        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $blog->save();
        $blog->posts()->save($post);

        return fractal()
            ->item($blog)
            ->parseIncludes(['user', 'posts', 'posts.user'])
            ->transformWith(new BlogTransformer)
            ->toArray();

    }
}
