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
            ->with([
                'postType:id,title',
                'categories:id,name,slug',
                'user:id,name',
                'variations' => function ($query) {
                    $query->orderBy('order')->orderBy('price');
                }
            ])
            ->firstOrFail();

        // Calculate starting from price
        $startingPrice = $property->variations->isNotEmpty()
            ? $property->variations->min('price')
            : ($property->content['price'] ?? 0);

        return Inertia::render('Properties/Show', [
            'property' => $property,
            'startingPrice' => $startingPrice,
            'hasVariations' => $property->variations->isNotEmpty(),
        ]);
    }
}
