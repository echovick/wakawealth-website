<?php

namespace Modules\Cms\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Cms\Models\PostType;

final readonly class CreatePostTypeAction
{
    /**
     * Execute the action
     *
     * @param array<string, mixed> $data
     * @return PostType
     */
    public function execute(array $data): PostType
    {
        return DB::transaction(function () use ($data) {
            $postType = new PostType();
            $postType->title = $data['title'];
            $postType->slug = $data['slug'];
            $postType->description = $data['description'] ?? null;
            $postType->active = $data['active'] ?? true;

            // Ensure empty content is saved as object, not array
            $content = $data['content'] ?? [];
            $postType->content = empty($content) ? (object) [] : $content;

            $postType->save();

            Log::info('Post type created', [
                'post_type_id' => $postType->id,
                'slug' => $postType->slug,
            ]);

            return $postType;
        });
    }
}
