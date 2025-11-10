<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Actions\DeletePageAction;
use Modules\Cms\Models\Page;

final class PageDestroyController
{
    public function __construct(
        private readonly DeletePageAction $deletePageAction,
    ) {
    }

    public function __invoke(Page $page): RedirectResponse
    {
        $this->deletePageAction->execute($page);

        return redirect()
            ->route('cms.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
