<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Page;

final class PageShowController
{
    public function __invoke(string $slug): Response
    {
        $page = Page::query()
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('DynamicPage', [
            'page' => $page,
        ]);
    }
}
