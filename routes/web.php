<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AccountSettingsController;
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

// Account Settings
Route::get('/account-settings', [AccountSettingsController::class, 'index'])->name('account-settings.index');
Route::post('/account-settings', [AccountSettingsController::class, 'update'])->name('account-settings.update');
