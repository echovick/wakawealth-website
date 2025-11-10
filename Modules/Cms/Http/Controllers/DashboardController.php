<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\Contact;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\Post;

/**
 * @author WakaWealth Development Team
 */
final class DashboardController
{
    /**
     * Display the CMS dashboard.
     */
    public function __invoke(): Response
    {
        $stats = [
            'pagesCount' => Page::query()->count(),
            'postsCount' => Post::query()->count(),
            'categoriesCount' => Category::query()->count(),
            'contactsCount' => Contact::query()->count(),
        ];

        return Inertia::render('Cms/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
