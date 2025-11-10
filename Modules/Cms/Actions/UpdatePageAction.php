<?php

namespace Modules\Cms\Actions;

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
        $page->slug = $data['slug'];
        $page->title = $data['title'];
        $page->description = $data['description'] ?? null;
        $page->content = $data['content'] ?? [];
        $page->save();

        return $page;
    }
}
