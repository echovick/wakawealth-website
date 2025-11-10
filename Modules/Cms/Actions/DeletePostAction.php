<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Post;

final readonly class DeletePostAction
{
    /**
     * Execute the action
     *
     * @param Post $post
     * @return bool
     */
    public function execute(Post $post): bool
    {
        return $post->delete();
    }
}
