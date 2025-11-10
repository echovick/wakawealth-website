<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Actions\UpdatePageAction;
use Modules\Cms\Http\Controllers\PageUpdateRequest;
use Modules\Cms\Models\Page;

final class PageUpdateController
{
    public function __construct(
        private readonly UpdatePageAction $updatePageAction,
    ) {
    }

    public function __invoke(Page $page, PageUpdateRequest $request): RedirectResponse
    {
        $this->updatePageAction->execute($page, $request->validated());

        return redirect()
            ->route('cms.pages.edit', ['page' => $page])
            ->with('success', 'Page updated successfully.');
    }
}
