<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Http\Requests\CategoryStoreRequest;
use Modules\Cms\Models\Category;

/**
 * @author WakaWealth Development Team
 */
final class CategoryStoreController
{
    /**
     * Store a newly created category in storage.
     */
    public function __invoke(CategoryStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = $validated['slug'];
        $category->image = $validated['image'] ?? null;
        $category->description = $validated['description'] ?? null;
        $category->parent_id = $validated['parent_id'] ?? null;
        $category->content = $validated['content'] ?? [];
        $category->save();

        return redirect()
            ->route('cms.categories.index')
            ->with('success', 'Category created successfully.');
    }
}
