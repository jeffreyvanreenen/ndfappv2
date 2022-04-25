<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DossiersController;
use App\Http\Controllers\RSSfeedsController;
use App\Http\Controllers\SourceCatagoriesController;

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
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('dossier', DossiersController::class)->middleware(['auth', 'verified']);
Route::resource('bronnen/rss', RSSfeedsController::class)->middleware(['auth', 'verified']);
Route::resource('sources', SourceCatagoriesController::class)->middleware(['auth', 'verified']);

Route::get('scrape/rss/', [RSSfeedsController::class, 'scrape'])->middleware(['auth', 'verified'])->name('rss.scrape');


require __DIR__.'/auth.php';
