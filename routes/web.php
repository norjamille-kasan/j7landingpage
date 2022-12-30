<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'services' => \App\Models\Service::all(),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(\App\Http\Controllers\ServiceController::class)->middleware(['auth'])->group(function () {
    Route::get('/services', 'index')->name('services.index');
    Route::get('/services/create', 'create')->name('services.create');
    Route::post('/services', 'store')->name('services.store');
    Route::get('/services/{service}/edit', 'edit')->name('services.edit');
    Route::post('/services/{service}', 'update')->name('services.update');
    Route::delete('/services/{service}', 'destroy')->name('services.destroy');
});

Route::controller(\App\Http\Controllers\ProjectController::class)->middleware(['auth'])->group(function () {
    Route::get('/projects', 'index')->name('projects.index');
    Route::get('/projects/create', 'create')->name('projects.create');
    Route::post('/projects', 'store')->name('projects.store');
    Route::get('/projects/{project}/edit', 'edit')->name('projects.edit');
    Route::post('/projects/{project}', 'update')->name('projects.update');
    Route::delete('/projects/{project}', 'destroy')->name('projects.destroy');
});

Route::controller(\App\Http\Controllers\TeamController::class)->middleware(['auth'])->group(function () {
    Route::get('/teams', 'index')->name('teams.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
