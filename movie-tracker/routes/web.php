<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('movie/movies');
})->middleware(['auth', 'verified'])->name('movies');

Route::get('/dashboard', function () {
    return view('movie/movies');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/privacy', function(){
    return view('about/privacy');
})->name('privacy');

Route::post('/search-movies', [MovieController::class, 'searchMovies'])->middleware(['auth', 'verified'])->name('search.movies');
Route::get('/my-movies', [MovieController::class, 'listMovies'])->middleware(['auth', 'verified'])->name('my.movies');
Route::post('/record-movie', [MovieController::class, 'recordMovie'])->middleware(['auth', 'verified'])->name('record.movie');
Route::delete('/delete-movie/{id}', [MovieController::class, 'deleteMovie'])->middleware(['auth', 'verified'])->name('delete.movie');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
