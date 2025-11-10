<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Actions\CreatePostTypeAction;
use Modules\Cms\Http\Requests\PostTypeStoreRequest;

/**
 * @author WakaWealth Development Team
 */
final class PostTypeStoreController
{
    public function __construct(
        private readonly CreatePostTypeAction $createPostTypeAction,
    ) {}

    /**
     * Store a newly created post type in storage.
     */
    public function __invoke(PostTypeStoreRequest $request): RedirectResponse
    {
        $this->createPostTypeAction->execute($request->validated());

        return redirect()
            ->route('cms.post-types.index')
            ->with('success', 'Post type created successfully.');
    }
}
