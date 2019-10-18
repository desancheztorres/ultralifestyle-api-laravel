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
//        $blogs = Blog::latestFirst()->paginate(3);
        $blogs = Blog::latestFirst()->get();
//        $blogsCollection = $blogs->getCollection();

        return fractal()
            ->collection($blogs)
            ->parseIncludes(['user'])
            ->transformWith(new BlogTransformer)
//            ->paginateWith(new IlluminatePaginatorAdapter($blogs))
            ->toArray();
    }

    public function show(Blog $blog) {

        return fractal()
            ->item($blog)
            ->parseIncludes(['user', 'posts', 'posts.user', 'posts.likes'])
            ->transformWith(new BlogTransformer)
            ->toArray();
    }

    public function latest() {

        $blog = Blog::latest('created_at')->first();

        return fractal()
            ->item($blog)
            ->transformWith(new BlogTransformer)
            ->toArray();
    }

    public function store(StoreBlogRequest $request) {
        $blog = new Blog;
        $blog->title = $request->title;
        $blog->image = $request->image;
        $blog->description = $request->description;
        $blog->body = $request->body;
        $blog->author = $request->author;
        $blog->url = $request->url;

        $blog->user()->associate($request->user());

        $blog->save();

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
        $blog->body = $request->get('body', $blog->body);
        $blog->author = $request->get('author', $blog->author);
        $blog->url = $request->get('url', $blog->url);
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