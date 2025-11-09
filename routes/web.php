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

Route::get('/education', function () {
    return Inertia::render('Education');
})->name('education');

// Workshops
Route::get('/education/workshops', function () {
    return Inertia::render('Education/Workshops', [
        'workshops' => [], // Will be populated from database
    ]);
})->name('education.workshops.index');

Route::get('/education/workshops/{slug}', function ($slug) {
    return Inertia::render('Education/WorkshopDetails', [
        'workshop' => [], // Will be populated from database
    ]);
})->name('education.workshops.show');

// Learning Paths
Route::get('/education/learning-paths', function () {
    return Inertia::render('Education/LearningPaths', [
        'learningPaths' => [], // Will be populated from database
    ]);
})->name('education.learningPaths.index');

Route::get('/education/learning-paths/{slug}', function ($slug) {
    return Inertia::render('Education/LearningPathDetails', [
        'learningPath' => [], // Will be populated from database
    ]);
})->name('education.learningPaths.show');

// Blog
Route::get('/blog', function () {
    return Inertia::render('Blog/Index', [
        'posts' => [], // Will be populated from database
        'categories' => [], // Will be populated from database
    ]);
})->name('blog.index');

Route::get('/blog/{slug}', function ($slug) {
    return Inertia::render('Blog/Details', [
        'post' => [], // Will be populated from database
        'relatedPosts' => [], // Will be populated from database
    ]);
})->name('blog.show');

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
