<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Category;

final readonly class UpdateCategoryAction
{
    /**
     * Execute the action
     *
     * @param Category $category
     * @param array<string, mixed> $data
     * @return Category
     */
    public function execute(Category $category, array $data): Category
    {
        $category->title = $data['title'];
        $category->description = $data['description'] ?? null;
        $category->content = $data['content'] ?? [];
        $category->save();

        return $category;
    }
}
