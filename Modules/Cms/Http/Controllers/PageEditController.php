<?php

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\Post;
use Modules\Cms\Services\FieldGroupResolverService;

final class PageEditController
{
    public function __construct(
        private readonly FieldGroupResolverService $fieldGroupResolver,
    ) {
    }

    public function __invoke(Page $page): Response
    {
        $fieldGroups = $this->fieldGroupResolver->resolveFieldGroups('page', $page);

        $posts = Post::query()
            ->with('postType:id,title')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'slug', 'post_type_id', 'published_at']);

        return Inertia::render('Cms/Pages/Edit', [
            'page' => $page,
            'fieldGroups' => $fieldGroups,
            'posts' => $posts,
        ]);
    }
}
