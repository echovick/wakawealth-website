<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Models\Category;

/**
 * @author WakaWealth Development Team
 */
final class CategoryDestroyController
{
    /**
     * Remove the specified category from storage.
     */
    public function __invoke(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('cms.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
