<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Post;

final readonly class CreatePostAction
{
    /**
     * Execute the action
     *
     * @param array<string, mixed> $data
     * @return Post
     */
    public function execute(array $data): Post
    {
        $post = new Post();
        $post->post_type_id = $data['post_type_id'];
        $post->user_id = $data['user_id'];
        $post->title = $data['title'];
        $post->slug = $data['slug'];
        $post->content = $data['content'] ?? [];
        $post->published_at = $data['published_at'] ?? null;
        $post->save();

        // Attach categories if provided
        if (isset($data['category_ids']) && is_array($data['category_ids'])) {
            foreach ($data['category_ids'] as $categoryId) {
                $post->categories()->attach($categoryId, [
                    'post_type_id' => $data['post_type_id'],
                ]);
            }
        }

        return $post;
    }
}
