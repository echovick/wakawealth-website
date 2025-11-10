<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;

/**
 * @author WakaWealth Development Team
 */
final class CategoryIndexController
{
    /**
     * Display a listing of categories.
     */
    public function __invoke(): Response
    {
        $categories = Category::query()
            ->with('parent')
            ->withCount('posts')
            ->orderBy('parent_id')
            ->orderBy('name')
            ->paginate(50);

        return Inertia::render('Cms/Categories/Index', [
            'categories' => $categories,
        ]);
    }
}
