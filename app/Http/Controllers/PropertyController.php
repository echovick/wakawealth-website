<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Post;

final class PropertyController
{
    public function __invoke(string $slug): Response
    {
        $property = Post::query()
            ->where('slug', $slug)
            ->with(['postType:id,title', 'categories:id,name,slug', 'user:id,name'])
            ->firstOrFail();

        return Inertia::render('Properties/Show', [
            'property' => $property,
        ]);
    }
}
