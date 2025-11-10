<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Category;
use Modules\Cms\Models\Post;

final class LocationsController
{
    public function __invoke(): Response
    {
        // Fetch all location categories (parent_id = 1)
        $locationCategories = Category::query()
            ->where('parent_id', 1)
            ->orderBy('name')
            ->get();

        $siteLocations = [];
        $homeLocations = [];

        foreach ($locationCategories as $location) {
            // Count properties in this location for each property type
            $sitesCount = Post::query()
                ->where('post_type_id', 4)
                ->whereNotNull('published_at')
                ->whereHas('categories', function ($query) use ($location) {
                    $query->where('categories.id', $location->id);
                })
                ->whereHas('categories', function ($query) {
                    $query->where('categories.id', 9); // Sites & Services
                })
                ->count();

            $homesCount = Post::query()
                ->where('post_type_id', 4)
                ->whereNotNull('published_at')
                ->whereHas('categories', function ($query) use ($location) {
                    $query->where('categories.id', $location->id);
                })
                ->whereHas('categories', function ($query) {
                    $query->where('categories.id', 10); // Homes
                })
                ->count();

            // Build location data
            $locationData = [
                'name' => $location->name,
                'slug' => $location->slug,
                'propertyCount' => 0,
                'image' => $location->image,
                'description' => '', // Can be added to categories table if needed
                'highlights' => [], // Can be added to categories table if needed
            ];

            // Add to sites locations if has sites
            if ($sitesCount > 0) {
                $siteLocations[] = array_merge($locationData, [
                    'propertyCount' => $sitesCount,
                ]);
            }

            // Add to homes locations if has homes
            if ($homesCount > 0) {
                $homeLocations[] = array_merge($locationData, [
                    'propertyCount' => $homesCount,
                ]);
            }
        }

        // Calculate stats
        $totalSiteLocations = count($siteLocations);
        $totalHomeLocations = count($homeLocations);
        $totalProperties = Post::query()
            ->where('post_type_id', 4)
            ->whereNotNull('published_at')
            ->count();

        return Inertia::render('Locations', [
            'siteLocations' => $siteLocations,
            'homeLocations' => $homeLocations,
            'stats' => [
                'siteLocations' => $totalSiteLocations,
                'homeLocations' => $totalHomeLocations,
                'totalProperties' => $totalProperties,
            ],
        ]);
    }
}
