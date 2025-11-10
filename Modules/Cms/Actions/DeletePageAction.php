<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Page;

final readonly class DeletePageAction
{
    /**
     * Execute the action
     *
     * @param Page $page
     * @return bool
     */
    public function execute(Page $page): bool
    {
        return $page->delete();
    }
}
