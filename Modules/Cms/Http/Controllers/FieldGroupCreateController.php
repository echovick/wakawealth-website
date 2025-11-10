<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\Post;
use Modules\Cms\Models\PostType;
use Modules\Cms\Services\FieldRegistryService;

/**
 * @author WakaWealth Development Team
 */
final class FieldGroupCreateController
{
    public function __construct(
        private readonly FieldRegistryService $fieldRegistry,
    ) {}

    /**
     * Show the form for creating a new field group.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Cms/FieldGroups/Create', [
            'fieldTypes' => $this->fieldRegistry->getFieldTypesForForm(),
            'pages' => Page::query()->orderBy('title')->get(['id', 'title']),
            'posts' => Post::query()->with('postType:id,title')->orderBy('title')->get(['id', 'title', 'post_type_id']),
            'postTypes' => PostType::query()->where('active', true)->orderBy('title')->get(['id', 'title']),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }
}
