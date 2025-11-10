<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Page;

final class HomeController
{
    public function __invoke(): Response
    {
        $homePage = Page::query()
            ->where('slug', 'home')
            ->first();

        $heroSlider = $homePage?->content['hero_slider'] ?? [];
        $aboutSection = $homePage?->content['about_section'] ?? null;

        return Inertia::render('Home', [
            'heroSlider'         => $heroSlider,
            'aboutSection'       => $aboutSection,
            'stats'              => [
                'yearsExperience'  => 10,
                'propertiesSold'   => 500,
                'satisfiedClients' => 1000,
                'locations'        => 12,
            ],
            'featuredLocations'  => [], // Will be populated from database
            'featuredProperties' => [], // Will be populated from database
            'testimonials'       => [], // Will be populated from database
        ]);
    }
}
