<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Recipes
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipe-details/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/share-a-recipe', [RecipeController::class, 'create'])->name('recipes.create');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

//Comment and Favorites
Route::post('/recipes/{recipe}/comment', [RecipeController::class, 'addComment'])->name('recipes.comment');
Route::post('/recipes/{recipe}/toggle-favorite', [RecipeController::class, 'toggleFavorite'])->name('recipes.toggleFavorite');
