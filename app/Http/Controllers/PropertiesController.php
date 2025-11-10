<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Post;

final class PropertiesController
{
    public function __invoke(): Response
    {
        // Fetch all published properties
        $properties = Post::query()
            ->where('post_type_id', 4) // Properties post type
            ->whereNotNull('published_at')
            ->with(['categories:id,name,slug,parent_id'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('published_at', 'desc')
            ->get();

        $formattedProperties = $properties->map(function ($property) {
            // Use post image first, fallback to first gallery image
            $image = $property->image;

            if (!$image && isset($property->content['gallery']) && is_array($property->content['gallery']) && count($property->content['gallery']) > 0) {
                $firstImage = $property->content['gallery'][0];
                $image = $firstImage['image'] ?? null;
            }

            // Determine property type from categories
            // Sites & Services (id: 9) = 'site', Homes (id: 10) = 'home'
            $propertyTypeCategory = $property->categories->first(fn($cat) => $cat->parent_id === 8);
            $type = 'site'; // default
            if ($propertyTypeCategory && $propertyTypeCategory->id === 10) {
                $type = 'home';
            }

            // Get location category (parent_id = 1)
            $locationCategory = $property->categories->first(fn($cat) => $cat->parent_id === 1);

            return [
                'id' => $property->id,
                'title' => $property->title,
                'slug' => $property->slug,
                'type' => $type,
                'location' => $locationCategory?->name ?? 'N/A',
                'price' => $property->content['price'] ?? 0,
                'size' => $property->content['size'] ?? 'N/A',
                'image' => $image ?? '',
                'status' => $property->content['status'] ?? 'available',
                'bedrooms' => $type === 'home' ? ($property->content['bedrooms'] ?? null) : null,
                'bathrooms' => $type === 'home' ? ($property->content['bathrooms'] ?? null) : null,
            ];
        });

        return Inertia::render('Properties', [
            'properties' => $formattedProperties->toArray(),
        ]);
    }
}
