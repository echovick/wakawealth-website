<?php

namespace Modules\Cms\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Cms\Models\PostType;

final readonly class UpdatePostTypeAction
{
    /**
     * Execute the action
     *
     * @param PostType $postType
     * @param array<string, mixed> $data
     * @return PostType
     */
    public function execute(PostType $postType, array $data): PostType
    {
        return DB::transaction(function () use ($postType, $data) {
            $postType->title = $data['title'];
            $postType->slug = $data['slug'];
            $postType->description = $data['description'] ?? null;
            $postType->active = $data['active'] ?? true;

            // Ensure empty content is saved as object, not array
            $content = $data['content'] ?? [];
            $postType->content = empty($content) ? (object) [] : $content;

            $postType->save();

            Log::info('Post type updated', [
                'post_type_id' => $postType->id,
                'slug' => $postType->slug,
            ]);

            return $postType;
        });
    }
}
