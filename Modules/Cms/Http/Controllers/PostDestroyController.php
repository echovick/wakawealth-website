<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Models\Post;

/**
 * @author WakaWealth Development Team
 */
final class PostDestroyController
{
    /**
     * Remove the specified post from storage.
     */
    public function __invoke(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('cms.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
