<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Post;

final readonly class UpdatePostAction
{
    /**
     * Execute the action
     *
     * @param Post $post
     * @param array<string, mixed> $data
     * @return Post
     */
    public function execute(Post $post, array $data): Post
    {
        $post->post_type_id = $data['post_type_id'];
        $post->title = $data['title'];
        $post->slug = $data['slug'];
        $post->content = $data['content'] ?? [];
        $post->published_at = $data['published_at'] ?? null;
        $post->save();

        // Sync categories if provided
        if (isset($data['category_ids']) && is_array($data['category_ids'])) {
            $syncData = [];
            foreach ($data['category_ids'] as $categoryId) {
                $syncData[$categoryId] = ['post_type_id' => $data['post_type_id']];
            }
            $post->categories()->sync($syncData);
        }

        return $post;
    }
}
