<?php

namespace Modules\Cms\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Cms\Models\Page;

final readonly class UpdatePageAction
{
    /**
     * Execute the action
     *
     * @param Page $page
     * @param array<string, mixed> $data
     * @return Page
     */
    public function execute(Page $page, array $data): Page
    {
        return DB::transaction(function () use ($page, $data) {
            $page->slug = $data['slug'];
            $page->title = $data['title'];
            $page->description = $data['description'] ?? null;

            // Ensure empty content is saved as object, not array
            $content = $data['content'] ?? [];
            $page->content = empty($content) ? (object) [] : $content;

            $page->save();

            Log::info('Page updated', [
                'page_id' => $page->id,
                'slug' => $page->slug,
                'content_keys' => array_keys($content),
            ]);

            return $page;
        });
    }
}
