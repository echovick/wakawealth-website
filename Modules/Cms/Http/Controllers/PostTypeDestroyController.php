<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Actions\DeletePostTypeAction;
use Modules\Cms\Models\PostType;

/**
 * @author WakaWealth Development Team
 */
final class PostTypeDestroyController
{
    public function __construct(
        private readonly DeletePostTypeAction $deletePostTypeAction,
    ) {}

    /**
     * Remove the specified post type from storage.
     */
    public function __invoke(PostType $postType): RedirectResponse
    {
        $this->deletePostTypeAction->execute($postType);

        return redirect()
            ->route('cms.post-types.index')
            ->with('success', 'Post type deleted successfully.');
    }
}
