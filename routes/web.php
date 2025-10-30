<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Home', [
        'stats' => [
            'yearsExperience' => 10,
            'propertiesSold' => 500,
            'satisfiedClients' => 1000,
            'locations' => 12,
        ],
        'featuredLocations' => [], // Will be populated from database
        'featuredProperties' => [], // Will be populated from database
        'testimonials' => [], // Will be populated from database
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
