<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\PostType;

/**
 * @author WakaWealth Development Team
 */
final class PostTypeIndexController
{
    /**
     * Display a listing of the post types.
     */
    public function __invoke(): Response
    {
        $postTypes = PostType::query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Cms/PostTypes/Index', [
            'postTypes' => $postTypes,
        ]);
    }
}
