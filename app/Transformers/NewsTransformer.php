<?php

namespace App\Transformers;

use App\Models\News;
use League\Fractal\TransformerAbstract;

class NewsTransformer extends TransformerAbstract {

    public function transform(News $news) {
        return [
            'id' => $news->id,
            'title' => $news->title,
            'image' => $news->image,
            'description' => $news->description,
            'body' => $news->body,
            'author' => $news->author,
            'url' => $news->url,
            'created_at' => $news->created_at->toDateTimeString(),
            'created_at_human' => $news->created_at->diffForHumans(),
        ];
    }
}