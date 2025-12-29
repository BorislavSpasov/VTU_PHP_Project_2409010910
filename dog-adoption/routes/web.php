<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('dogs', DogController::class);
    Route::resource('adoptions', AdoptionController::class);
});


use App\Http\Controllers\DogAdminController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dogs', [DogAdminController::class, 'index'])->name('admin.dogs.index');
    Route::post('/admin/dogs', [DogAdminController::class, 'store'])->name('admin.dogs.store');
    Route::get('/admin/dogs/{dog}/edit', [DogAdminController::class, 'edit'])->name('admin.dogs.edit');
    Route::patch('/admin/dogs/{dog}', [DogAdminController::class, 'update'])->name('admin.dogs.update');
    Route::delete('/admin/dogs/{dog}', [DogAdminController::class, 'destroy'])->name('admin.dogs.destroy');
});

use App\Http\Controllers\DogController;

// Public dog listings
Route::get('/dogs', [DogController::class, 'index'])->name('dogs.index');
Route::get('/dogs/{dog}', [DogController::class, 'show'])->name('dogs.show');

use App\Http\Controllers\AdoptionController;

Route::middleware(['auth'])->group(function () {
    Route::post('/adoptions', [AdoptionController::class, 'store'])->name('adoptions.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/adoptions', [AdoptionController::class, 'index'])->name('admin.adoptions.index');
    Route::patch('/admin/adoptions/{adoption}', [AdoptionController::class, 'update'])->name('admin.adoptions.update');
});

use App\Http\Controllers\Admin\UserAdminController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserAdminController::class, 'index'])
        ->name('admin.users.index');

    Route::patch('/admin/users/{user}/toggle', [UserAdminController::class, 'toggle'])
        ->name('admin.users.toggle');
});
