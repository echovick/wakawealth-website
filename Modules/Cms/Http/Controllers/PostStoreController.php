<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Cms\Http\Requests\PostStoreRequest;
use Modules\Cms\Models\Post;

/**
 * @author WakaWealth Development Team
 */
final class PostStoreController
{
    /**
     * Store a newly created post in storage.
     */
    public function __invoke(PostStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $post = new Post();
        $post->post_type_id = $validated['post_type_id'];
        $post->user_id = Auth::id();
        $post->title = $validated['title'];
        $post->slug = $validated['slug'];
        $post->content = $validated['content'] ?? [];
        $post->published_at = $validated['status'] === 'published' ? now() : null;
        $post->save();

        // Always sync categories (even if empty array)
        $categories = $validated['categories'] ?? [];
        $syncData = collect($categories)->mapWithKeys(
            fn($categoryId) => [$categoryId => ['post_type_id' => $post->post_type_id]]
        );
        $post->categories()->sync($syncData);

        return redirect()
            ->route('cms.posts.index')
            ->with('success', 'Post created successfully.');
    }
}
