<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\PostType;

/**
 * @author WakaWealth Development Team
 */
final class PostTypeEditController
{
    /**
     * Show the form for editing the specified post type.
     */
    public function __invoke(PostType $postType): Response
    {
        return Inertia::render('Cms/PostTypes/Edit', [
            'postType' => $postType,
        ]);
    }
}
