<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Http\Requests\CategoryUpdateRequest;
use Modules\Cms\Models\Category;

/**
 * @author WakaWealth Development Team
 */
final class CategoryUpdateController
{
    /**
     * Update the specified category in storage.
     */
    public function __invoke(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        $category->name = $validated['name'];
        $category->slug = $validated['slug'];
        $category->description = $validated['description'] ?? null;
        $category->parent_id = $validated['parent_id'] ?? null;
        $category->content = $validated['content'] ?? [];
        $category->save();

        return redirect()
            ->route('cms.categories.index')
            ->with('success', 'Category updated successfully.');
    }
}
