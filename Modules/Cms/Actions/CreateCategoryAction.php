<?php

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Category;

final readonly class CreateCategoryAction
{
    /**
     * Execute the action
     *
     * @param array<string, mixed> $data
     * @return Category
     */
    public function execute(array $data): Category
    {
        $category = new Category();
        $category->title = $data['title'];
        $category->description = $data['description'] ?? null;
        $category->content = $data['content'] ?? [];
        $category->save();

        return $category;
    }
}
