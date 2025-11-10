<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Page;

final readonly class CreatePageAction
{
    /**
     * Execute the action
     *
     * @param array<string, mixed> $data
     * @return Page
     */
    public function execute(array $data): Page
    {
        $page = new Page();
        $page->slug = $data['slug'];
        $page->title = $data['title'];
        $page->description = $data['description'] ?? null;
        $page->content = $data['content'] ?? [];
        $page->save();

        return $page;
    }
}
