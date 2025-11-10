<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Actions\CreatePageAction;
use Modules\Cms\Http\Controllers\PageStoreRequest;

final class PageStoreController
{
    public function __construct(
        private readonly CreatePageAction $createPageAction,
    ) {
    }

    public function __invoke(PageStoreRequest $request): RedirectResponse
    {
        $page = $this->createPageAction->execute($request->validated());

        return redirect()
            ->route('cms.pages.edit', ['page' => $page])
            ->with('success', 'Page created successfully.');
    }
}
