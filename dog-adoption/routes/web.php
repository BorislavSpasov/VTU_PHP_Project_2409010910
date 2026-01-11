<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DogController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\DogAdminController;
use App\Http\Controllers\AdoptionAdminController;
use App\Http\Controllers\Admin\UserAdminController;

// Public routes
Route::view('/', 'welcome')->name('home');

Route::get('/dogs', [DogController::class, 'index'])->name('dogs.index');
Route::get('/dogs/{dog}', [DogController::class, 'show'])->name('dogs.show');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');

    // Users can submit adoptions
    Route::post('/adoptions', [AdoptionController::class, 'store'])->name('adoptions.store');
});

// Dashboard route
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/auth.php';

// Admin routes (Admins + Super Admins)
Route::middleware(['auth', 'admin'])->group(function () {

    // Dog management (admin prefixed names)
    Route::resource('/admin/dogs', DogAdminController::class, ['as' => 'admin']);

    // Adoption management (admin prefixed names)
    Route::resource('/admin/adoptions', AdoptionController::class, ['as' => 'admin']);

    // User management for admins (toggle only)
    Route::get('/admin/users', [UserAdminController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/toggle', [UserAdminController::class, 'toggle'])->name('admin.users.toggle');
});

// Super Admin ONLY routes
Route::middleware(['auth', 'super-admin'])->group(function () {
    Route::resource('/admin/users', UserAdminController::class, ['as' => 'admin']);
});

Route::delete('/admin/adoptions/{adoption}', [AdoptionController::class, 'destroy'])
    ->name('admin.adoptions.destroy');


