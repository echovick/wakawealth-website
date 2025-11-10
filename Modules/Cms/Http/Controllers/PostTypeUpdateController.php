<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Actions\UpdatePostTypeAction;
use Modules\Cms\Http\Requests\PostTypeUpdateRequest;
use Modules\Cms\Models\PostType;

/**
 * @author WakaWealth Development Team
 */
final class PostTypeUpdateController
{
    public function __construct(
        private readonly UpdatePostTypeAction $updatePostTypeAction,
    ) {}

    /**
     * Update the specified post type in storage.
     */
    public function __invoke(PostType $postType, PostTypeUpdateRequest $request): RedirectResponse
    {
        $this->updatePostTypeAction->execute($postType, $request->validated());

        return redirect()
            ->route('cms.post-types.edit', $postType)
            ->with('success', 'Post type updated successfully.');
    }
}
