<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DossiersController;
use App\Http\Controllers\RSSfeedsController;
use App\Http\Controllers\SourceCatagoriesController;
use App\Http\Controllers\TwitterApiController;
use App\Http\Controllers\FacebookApiController;
use App\Http\Controllers\TelegramBotsController;

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
Route::resource('twitter', TwitterApiController::class)->middleware(['auth', 'verified']);
Route::resource('facebook', FacebookApiController::class)->middleware(['auth', 'verified']);
Route::resource('telegram', TelegramBotsController::class)->middleware(['auth', 'verified']);

Route::get('scrape/rss/', [RSSfeedsController::class, 'scrape'])->middleware(['auth', 'verified'])->name('rss.scrape');
Route::get('chats', [TelegramBotsController::class, 'chats'])->middleware(['auth', 'verified'])->name('chats');
Route::get('crawler', [\App\Http\Controllers\CrawlerController::class, 'dpgcrawler']);

require __DIR__.'/auth.php';
