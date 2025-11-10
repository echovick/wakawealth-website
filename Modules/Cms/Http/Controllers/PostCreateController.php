<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\PostType;
use Modules\Cms\Services\FieldRegistryService;

/**
 * @author WakaWealth Development Team
 */
final class PostCreateController
{
    public function __construct(
        private readonly FieldRegistryService $fieldRegistry,
    ) {}

    /**
     * Show the form for creating a new post.
     */
    public function __invoke(): Response
    {
        $postTypes = PostType::query()
            ->where('active', true)
            ->orderBy('title')
            ->get();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return Inertia::render('Cms/Posts/Create', [
            'postTypes' => $postTypes,
            'categories' => $categories,
            'fieldTypes' => $this->fieldRegistry->getFieldTypes(),
        ]);
    }
}
