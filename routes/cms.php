<?php

use Illuminate\Support\Facades\Route;
use Modules\Cms\Http\Controllers\Auth\LoginShowController;
use Modules\Cms\Http\Controllers\Auth\LoginStoreController;
use Modules\Cms\Http\Controllers\Auth\LogoutController;
use Modules\Cms\Http\Controllers\CategoryDestroyController;
use Modules\Cms\Http\Controllers\CategoryIndexController;
use Modules\Cms\Http\Controllers\CategoryStoreController;
use Modules\Cms\Http\Controllers\CategoryUpdateController;
use Modules\Cms\Http\Controllers\ContactDestroyController;
use Modules\Cms\Http\Controllers\ContactIndexController;
use Modules\Cms\Http\Controllers\ContactShowController;
use Modules\Cms\Http\Controllers\ContactStoreController;
use Modules\Cms\Http\Controllers\FieldGroupCreateController;
use Modules\Cms\Http\Controllers\FieldGroupDestroyController;
use Modules\Cms\Http\Controllers\FieldGroupEditController;
use Modules\Cms\Http\Controllers\FieldGroupIndexController;
use Modules\Cms\Http\Controllers\FieldGroupStoreController;
use Modules\Cms\Http\Controllers\FieldGroupUpdateController;
use Modules\Cms\Http\Controllers\PageCreateController;
use Modules\Cms\Http\Controllers\PageDestroyController;
use Modules\Cms\Http\Controllers\PageEditController;
use Modules\Cms\Http\Controllers\PageIndexController;
use Modules\Cms\Http\Controllers\PageShowController;
use Modules\Cms\Http\Controllers\PageStoreController;
use Modules\Cms\Http\Controllers\PageUpdateController;
use Modules\Cms\Http\Controllers\PostCreateController;
use Modules\Cms\Http\Controllers\PostDestroyController;
use Modules\Cms\Http\Controllers\PostEditController;
use Modules\Cms\Http\Controllers\PostIndexController;
use Modules\Cms\Http\Controllers\PostStoreController;
use Modules\Cms\Http\Controllers\PostUpdateController;
use Modules\Cms\Http\Controllers\SettingIndexController;
use Modules\Cms\Http\Controllers\SettingUpdateController;
use Modules\Cms\Http\Middleware\EnsureCmsAccess;

// Public routes
Route::post('/contact', ContactStoreController::class)->name('contact.store');

// CMS Authentication routes
Route::prefix('cms')->name('cms.')->group(function (): void {
    Route::get('/login', LoginShowController::class)->name('login');
    Route::post('/login', LoginStoreController::class)->name('login.store');
    Route::post('/logout', LogoutController::class)->name('logout');
});

// Protected CMS routes
Route::prefix('cms')->name('cms.')->middleware([EnsureCmsAccess::class])->group(function (): void {
    // Dashboard
    Route::get('/', function () {
        return inertia('Cms/Dashboard');
    })->name('dashboard');

    // Pages
    Route::prefix('pages')->name('pages.')->group(function (): void {
        Route::get('/', PageIndexController::class)->name('index');
        Route::get('/create', PageCreateController::class)->name('create');
        Route::post('/', PageStoreController::class)->name('store');
        Route::get('/{page}/edit', PageEditController::class)->name('edit');
        Route::put('/{page}', PageUpdateController::class)->name('update');
        Route::delete('/{page}', PageDestroyController::class)->name('destroy');
    });

    // Posts
    Route::prefix('posts')->name('posts.')->group(function (): void {
        Route::get('/', PostIndexController::class)->name('index');
        Route::get('/create', PostCreateController::class)->name('create');
        Route::post('/', PostStoreController::class)->name('store');
        Route::get('/{post}/edit', PostEditController::class)->name('edit');
        Route::put('/{post}', PostUpdateController::class)->name('update');
        Route::delete('/{post}', PostDestroyController::class)->name('destroy');
    });

    // Categories
    Route::prefix('categories')->name('categories.')->group(function (): void {
        Route::get('/', CategoryIndexController::class)->name('index');
        Route::post('/', CategoryStoreController::class)->name('store');
        Route::put('/{category}', CategoryUpdateController::class)->name('update');
        Route::delete('/{category}', CategoryDestroyController::class)->name('destroy');
    });

    // Contacts
    Route::prefix('contacts')->name('contacts.')->group(function (): void {
        Route::get('/', ContactIndexController::class)->name('index');
        Route::get('/{contact}', ContactShowController::class)->name('show');
        Route::delete('/{contact}', ContactDestroyController::class)->name('destroy');
    });

    // Field Groups
    Route::prefix('field-groups')->name('field-groups.')->group(function (): void {
        Route::get('/', FieldGroupIndexController::class)->name('index');
        Route::get('/create', FieldGroupCreateController::class)->name('create');
        Route::post('/', FieldGroupStoreController::class)->name('store');
        Route::get('/{field_group}/edit', FieldGroupEditController::class)->name('edit');
        Route::put('/{field_group}', FieldGroupUpdateController::class)->name('update');
        Route::delete('/{field_group}', FieldGroupDestroyController::class)->name('destroy');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function (): void {
        Route::get('/', SettingIndexController::class)->name('index');
        Route::put('/', SettingUpdateController::class)->name('update');
    });
});

// Dynamic page route (should be last to avoid conflicts)
Route::get('/{slug}', PageShowController::class)
    ->where('slug', '^(?!cms|api|dashboard|blog|education|properties|locations|investment|contact|about).*$')
    ->name('page.show');
