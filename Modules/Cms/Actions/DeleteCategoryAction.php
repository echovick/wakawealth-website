<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Category;

final readonly class DeleteCategoryAction
{
    /**
     * Execute the action
     *
     * @param Category $category
     * @return bool
     */
    public function execute(Category $category): bool
    {
        return $category->delete();
    }
}
