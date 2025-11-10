<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/properties', function () {
    return Inertia::render('Properties', [
        'properties' => [], // Will be populated from database
    ]);
})->name('properties.index');

Route::get('/properties/{slug}', PropertyController::class)->name('properties.show');

Route::get('/locations', function () {
    return Inertia::render('Locations');
})->name('locations.index');

Route::get('/locations/{slug}', LocationController::class)->name('locations.show');

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
    return Inertia::render('Education/WorkshopDetails');
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
    return Inertia::render('Blog/Details');
})->name('blog.show');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/cms.php';
