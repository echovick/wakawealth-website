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

        $fieldGroups = $this->fieldGroupResolver->resolveFieldGroups('post', $post);

        $postTypes = PostType::query()
            ->where('active', true)
            ->orderBy('title')
            ->get();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $posts = Post::query()
            ->with('postType:id,title')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'slug', 'post_type_id', 'published_at']);

        return Inertia::render('Cms/Posts/Edit', [
            'post' => $post,
            'fieldGroups' => $fieldGroups,
            'postTypes' => $postTypes,
            'categories' => $categories,
            'posts' => $posts,
            'fieldTypes' => $this->fieldRegistry->getFieldTypes(),
        ]);
    }
}
