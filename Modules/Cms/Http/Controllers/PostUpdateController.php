<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Http\Requests\PostUpdateRequest;
use Modules\Cms\Models\Post;

/**
 * @author WakaWealth Development Team
 */
final class PostUpdateController
{
    /**
     * Update the specified post in storage.
     */
    public function __invoke(PostUpdateRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        $post->post_type_id = $validated['post_type_id'];
        $post->title = $validated['title'];
        $post->slug = $validated['slug'];
        $post->content = $validated['content'] ?? [];

        // Only set published_at if transitioning from draft to published
        if ($validated['status'] === 'published' && !$post->published_at) {
            $post->published_at = now();
        } elseif ($validated['status'] === 'draft') {
            $post->published_at = null;
        }

        $post->save();

        // Always sync categories (even if empty array to clear all)
        $categories = $validated['categories'] ?? [];
        $syncData = collect($categories)->mapWithKeys(
            fn($categoryId) => [$categoryId => ['post_type_id' => $post->post_type_id]]
        );
        $post->categories()->sync($syncData);

        // Reload the post with fresh relationships
        $post->refresh();
        $post->load(['postType', 'categories']);

        return redirect()
            ->route('cms.posts.edit', $post)
            ->with('success', 'Post updated successfully.');
    }
}
