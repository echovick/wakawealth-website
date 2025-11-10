<?php

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\Post;
use Modules\Cms\Models\PostType;
use Modules\Cms\Services\FieldGroupResolverService;
use Modules\Cms\Services\FieldRegistryService;

final class PageCreateController
{
    public function __construct(
        private readonly FieldGroupResolverService $fieldGroupResolver,
        private readonly FieldRegistryService $fieldRegistry,
    ) {
    }

    public function __invoke(): Response
    {
        $fieldGroups = $this->fieldGroupResolver->resolveFieldGroups('page');

        $posts = Post::query()
            ->with('postType:id,title')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'slug', 'post_type_id', 'published_at']);

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $postTypes = PostType::query()
            ->where('active', true)
            ->orderBy('title')
            ->get(['id', 'title', 'slug', 'active']);

        return Inertia::render('Cms/Pages/Create', [
            'fieldGroups' => $fieldGroups,
            'posts' => $posts,
            'categories' => $categories,
            'postTypes' => $postTypes,
            'fieldTypes' => $this->fieldRegistry->getFieldTypes(),
        ]);
    }
}
