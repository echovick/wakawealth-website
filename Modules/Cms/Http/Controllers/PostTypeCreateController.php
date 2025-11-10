<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/**
 * @author WakaWealth Development Team
 */
final class PostTypeCreateController
{
    /**
     * Show the form for creating a new post type.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Cms/PostTypes/Create');
    }
}
