<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\News\{StoreNewsRequest, UpdateNewsRequest};
use App\Models\News;
use App\Transformers\NewsTransformer;

class NewsController extends Controller
{
    public function index() {
        $news = News::latestFirst()->get();

        return fractal()
            ->collection($news)
            ->transformWith(new NewsTransformer)
            ->toArray();
    }

    public function show(News $news) {

        return fractal()
            ->item($news)
            ->transformWith(new NewsTransformer)
            ->toArray();
    }

    public function latest() {

        $news = News::latest('created_at')->first();

        return fractal()
            ->item($news)
            ->transformWith(new NewsTransformer)
            ->toArray();
    }

    public function store(StoreNewsRequest $request) {
        $news = new News;
        $news->title = $request->title;
        $news->image = $request->image;
        $news->description = $request->description;
        $news->body = $request->body;
        $news->author = $request->author;
        $news->url = $request->url;

        $news->save();

        return fractal()
            ->item($news)
            ->transformWith(new NewsTransformer)
            ->toArray();
    }

    public function update(UpdateNewsRequest $request, News $news) {
        $news->title = $request->get('title', $news->title);
        $news->image = $request->get('image', $news->image);
        $news->description = $request->get('description', $news->description);
        $news->body = $request->get('body', $news->body);
        $news->author = $request->get('author', $news->author);
        $news->url = $request->get('url', $news->url);
        $news->save();

        return fractal()
            ->item($news)
            ->transformWith(new NewsTransformer)
            ->toArray();
    }

    public function destroy(News $news) {
        $news->delete();

        return response(null, 204);
    }
}