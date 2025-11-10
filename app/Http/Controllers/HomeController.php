<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\Post;

final class HomeController
{
    public function __invoke(): Response
    {
        $homePage = Page::query()
            ->where('slug', 'home')
            ->first();

        $heroSlider = $homePage?->content['hero_slider'] ?? [];
        $aboutSection = $homePage?->content['about_section'] ?? null;

        // Get location categories with property counts and random images
        $locationCategories = Category::query()
            ->where('parent_id', 1) // Get child categories of "Locations" (id: 1)
            ->withCount('posts')    // Count properties for each location
            ->with(['posts' => function ($query) {
                // Get one random post that has a gallery
                $query->whereNotNull('content->gallery')
                      ->whereJsonLength('content->gallery', '>', 0)
                      ->inRandomOrder()
                      ->limit(1);
            }])
            ->orderBy('name')
            ->get();

        $featuredLocations = $locationCategories->map(function ($location) {
            // Use category image first, fallback to random property gallery image
            $image = $location->image;

            // If no category image, try to get a random image from a property's gallery
            if (!$image) {
                $firstPost = $location->posts->first();
                if ($firstPost && isset($firstPost->content['gallery']) && is_array($firstPost->content['gallery']) && count($firstPost->content['gallery']) > 0) {
                    $gallery = $firstPost->content['gallery'];
                    $randomImageData = $gallery[array_rand($gallery)];
                    $image = $randomImageData['image'] ?? null;
                }
            }

            return [
                'id' => $location->id,
                'name' => $location->name,
                'slug' => $location->slug,
                'image' => $image,
                'propertyCount' => $location->posts_count,
            ];
        })->toArray();

        // Get property type categories (Homes, Sites & Services)
        $propertyTypeCategories = Category::query()
            ->where('parent_id', 8) // Property Types parent category
            ->orderBy('name')
            ->get();

        // Get featured properties grouped by property type category
        $featuredPropertiesByType = [];
        foreach ($propertyTypeCategories as $propertyType) {
            $properties = Post::query()
                ->where('post_type_id', 4) // Properties post type
                ->where('is_featured', true)
                ->whereHas('categories', function ($query) use ($propertyType) {
                    $query->where('categories.id', $propertyType->id);
                })
                ->with(['categories:id,name,slug'])
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();

            $featuredPropertiesByType[$propertyType->slug] = [
                'id' => $propertyType->id,
                'name' => $propertyType->name,
                'slug' => $propertyType->slug,
                'properties' => $properties->map(function ($property) use ($propertyType) {
                    // Use post image first, fallback to first gallery image
                    $image = $property->image;

                    if (!$image && isset($property->content['gallery']) && is_array($property->content['gallery']) && count($property->content['gallery']) > 0) {
                        $firstImage = $property->content['gallery'][0];
                        $image = $firstImage['image'] ?? null;
                    }

                    // Get location category (parent_id = 1)
                    $location = $property->categories->first(fn($cat) => $cat->id !== $propertyType->id);

                    return [
                        'id' => $property->id,
                        'title' => $property->title,
                        'slug' => $property->slug,
                        'price' => $property->content['price'] ?? 0,
                        'image' => $image,
                        'location' => $location?->name,
                        'published_at' => $property->published_at,
                    ];
                })->toArray(),
            ];
        }

        return Inertia::render('Home', [
            'heroSlider'         => $heroSlider,
            'aboutSection'       => $aboutSection,
            'stats'              => [
                'yearsExperience'  => 10,
                'propertiesSold'   => 500,
                'satisfiedClients' => 1000,
                'locations'        => 12,
            ],
            'featuredLocations'  => $featuredLocations,
            'featuredProperties' => $featuredPropertiesByType,
            'propertyTypes'      => $propertyTypeCategories->toArray(),
            'testimonials'       => [], // Will be populated from database
        ]);
    }
}
