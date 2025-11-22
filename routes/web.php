<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

// Redirect root to /home
Route::redirect('/', '/home');

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Recipes
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipe-details/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/share-a-recipe', [RecipeController::class, 'create'])->middleware('auth')->name('recipes.create');
Route::post('/recipes', [RecipeController::class, 'store'])->middleware('auth')->name('recipes.store');
Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->middleware('auth')->name('recipes.update');
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->middleware('auth')->name('recipes.destroy');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

//Comment and Favorites
Route::post('/recipes/{recipe}/comment', [RecipeController::class, 'addComment'])->name('recipes.comment');
Route::post('/recipes/{recipe}/toggle-favorite', [RecipeController::class, 'toggleFavorite'])->name('recipes.toggleFavorite');

//Comment and Favorites
Route::post('/recipes/{recipe}/comment', [RecipeController::class, 'addComment'])->name('recipes.comment');
Route::post('/recipes/{recipe}/toggle-favorite', [RecipeController::class, 'toggleFavorite'])->name('recipes.toggleFavorite');

// Settings
Route::get('/settings', [SettingsController::class, 'index'])->middleware('auth')->name('settings.index');
Route::post('/settings', [SettingsController::class, 'update'])->middleware('auth')->name('settings.update');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Profile
Route::get('/profile/{user:username}', [ProfileController::class, 'show'])->name('profile');