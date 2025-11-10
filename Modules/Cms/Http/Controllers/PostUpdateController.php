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
        $post->published_at = $validated['published_at'] ?? null;
        $post->save();

        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return redirect()
            ->route('cms.posts.index')
            ->with('success', 'Post updated successfully.');
    }
}
