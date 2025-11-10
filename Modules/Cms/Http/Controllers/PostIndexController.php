<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Post;

/**
 * @author WakaWealth Development Team
 */
final class PostIndexController
{
    /**
     * Display a listing of posts.
     */
    public function __invoke(): Response
    {
        $posts = Post::query()
            ->with(['postType', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Cms/Posts/Index', [
            'posts' => $posts,
        ]);
    }
}
