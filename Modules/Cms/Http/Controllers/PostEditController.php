<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\Post;
use Modules\Cms\Models\PostType;
use Modules\Cms\Services\FieldGroupResolverService;
use Modules\Cms\Services\FieldRegistryService;

/**
 * @author WakaWealth Development Team
 */
final class PostEditController
{
    public function __construct(
        private readonly FieldGroupResolverService $fieldGroupResolver,
        private readonly FieldRegistryService $fieldRegistry,
    ) {}

    /**
     * Show the form for editing the specified post.
     */
    public function __invoke(Post $post): Response
    {
        $post->load(['postType', 'categories']);

        $fieldGroups = $this->fieldGroupResolver->resolveForEntity('post', [
            'post_type' => $post->post_type_id,
        ]);

        $postTypes = PostType::query()
            ->where('active', true)
            ->orderBy('title')
            ->get();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return Inertia::render('Cms/Posts/Edit', [
            'post' => $post,
            'fieldGroups' => $fieldGroups,
            'postTypes' => $postTypes,
            'categories' => $categories,
            'fieldTypes' => $this->fieldRegistry->getFieldTypes(),
        ]);
    }
}
