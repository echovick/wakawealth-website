<?php

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Post;
use Modules\Cms\Services\FieldGroupResolverService;

final class PageCreateController
{
    public function __construct(
        private readonly FieldGroupResolverService $fieldGroupResolver,
    ) {
    }

    public function __invoke(): Response
    {
        $fieldGroups = $this->fieldGroupResolver->resolveFieldGroups('page');

        $posts = Post::query()
            ->with('postType:id,title')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'slug', 'post_type_id', 'published_at']);

        return Inertia::render('Cms/Pages/Create', [
            'fieldGroups' => $fieldGroups,
            'posts' => $posts,
        ]);
    }
}
