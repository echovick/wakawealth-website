<?php

namespace Modules\Cms\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Cms\Models\PostType;

final readonly class DeletePostTypeAction
{
    /**
     * Execute the action
     *
     * @param PostType $postType
     * @return void
     */
    public function execute(PostType $postType): void
    {
        DB::transaction(function () use ($postType) {
            Log::info('Post type deleted', [
                'post_type_id' => $postType->id,
                'slug' => $postType->slug,
            ]);

            $postType->delete();
        });
    }
}
