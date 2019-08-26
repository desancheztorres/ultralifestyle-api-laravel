<?php

namespace App\Transformers;

use App\Models\Blog;
use League\Fractal\TransformerAbstract;

class BlogTransformer extends TransformerAbstract {

    protected $defaultIncludes = ['user'];

    public function transform(Blog $blog) {
        return [
            'id' => $blog->id,
            'title' => $blog->title,
            'image' => $blog->image,
            'description' => $blog->description,
            'created_at' => $blog->created_at->toDateTimeString(),
            'created_at_human' => $blog->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Blog $blog) {
        return $this->item($blog->user, new UserTransformer);
    }

    public function includePosts(Blog $blog) {
        return $this->collection($blog->posts, new PostTransformer);
    }
}