<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\Post;

final class LocationController
{
    public function __invoke(string $slug): Response
    {
        $location = Category::query()
            ->where('slug', $slug)
            ->firstOrFail();

        // Fetch properties in this location
        $properties = Post::query()
            ->whereHas('categories', function ($query) use ($location) {
                $query->where('categories.id', $location->id);
            })
            ->with(['postType:id,title', 'categories:id,name,slug'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return Inertia::render('Locations/Show', [
            'location' => $location,
            'properties' => $properties,
        ]);
    }
}
