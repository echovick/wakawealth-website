<?php

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Page;

final class PageIndexController
{
    public function __invoke(): Response
    {
        $pages = Page::query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Cms/Pages/Index', [
            'pages' => $pages,
        ]);
    }
}
