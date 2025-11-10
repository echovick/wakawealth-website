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
            ->withCount('posts')
            ->orderBy('name')
            ->paginate(15);

        return Inertia::render('Cms/Categories/Index', [
            'categories' => $categories,
        ]);
    }
}
