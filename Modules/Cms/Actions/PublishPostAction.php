<?php

namespace Modules\Cms\Actions;

use Illuminate\Support\Facades\Date;
use Modules\Cms\Models\Post;

final readonly class PublishPostAction
{
    /**
     * Execute the action
     *
     * @param Post $post
     * @return Post
     */
    public function execute(Post $post): Post
    {
        $post->published_at = Date::now();
        $post->save();

        return $post;
    }
}
