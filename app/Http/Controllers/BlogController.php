<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Blog;
use App\Models\Post;
use App\Transformers\BlogTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class BlogController extends Controller
{
    public function index() {
//        $blogs = Blog::latestFirst()->get();

        $blogs = Blog::latestFirst()->paginate(3);
        $blogsCollection = $blogs->getCollection();

        return fractal()
            ->collection($blogsCollection)
            ->parseIncludes(['user'])
            ->transformWith(new BlogTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($blogs))
            ->toArray();

//        return fractal()
//            ->collection($blogs)
//            ->parseIncludes(['user'])
//            ->transformWith(new BlogTransformer)
//            ->toArray();
    }

    public function show(Blog $blog) {

        return fractal()
            ->item($blog)
            ->parseIncludes(['user', 'posts', 'posts.user', 'posts.likes'])
            ->transformWith(new BlogTransformer)
            ->toArray();
    }

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

    public function update(UpdateTopicRequest $request, Blog $blog) {
        $this->authorize('update', $blog);
        $blog->title = $request->get('title', $blog->title);
        $blog->image = $request->get('image', $blog->image);
        $blog->description = $request->get('description', $blog->description);
        $blog->save();

        return fractal()
            ->item($blog)
            ->parseIncludes(['user', 'posts', 'posts.user'])
            ->transformWith(new BlogTransformer)
            ->toArray();
    }

    public function destroy(Blog $blog) {
        $this->authorize('destroy', $blog);

        $blog->delete();

        return response(null, 204);
    }
}