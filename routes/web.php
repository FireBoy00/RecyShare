<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root to /home
Route::redirect('/', '/home');

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Recipes
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipe-details/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/share-a-recipe', [RecipeController::class, 'create'])->name('recipes.create');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Authentication (temporary Blade-based routes)
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

use Illuminate\Http\Request;

Route::post('/signup', function (Request $request) {
    return 'Signup data received: ' . $request->input('email');
});

Route::post('/login', function (Request $request) {
    return 'Login data received: ' . $request->input('email');
});