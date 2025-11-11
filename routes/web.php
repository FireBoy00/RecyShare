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
Route::get('/share-a-recipe', [RecipeController::class, 'create'])->middleware('auth')->name('recipes.create');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');