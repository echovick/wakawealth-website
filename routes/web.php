<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
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
})->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/properties', function () {
    return Inertia::render('Properties', [
        'properties' => [], // Will be populated from database
    ]);
})->name('properties');

Route::get('/locations', function () {
    return Inertia::render('Locations');
})->name('locations');

Route::get('/investment/why-invest', function () {
    return Inertia::render('Investment/WhyInvest');
})->name('investment.why-invest');

Route::get('/education/blog', function () {
    return Inertia::render('Education');
})->name('education');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::post('/contact', function () {
    // Handle contact form submission
    return back()->with('success', 'Thank you for your message. We will get back to you within 24 hours.');
})->name('contact.submit');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

require __DIR__ . '/settings.php';
