<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');
Route::get('/home', function () {
    return view('home');
});

Route::get('/recipes', function () {
    return view('recipes');
});

Route::get('/categories', function () {
    return view('categories');
});

Route::get('/recipe-details', function () {
    return view('recipe-details');
});

Route::get('/share-a-recipe', function () {
    return view('share-a-recipe');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/login', function () {
    return view('login');
});

use Illuminate\Http\Request;

Route::post('/signup', function (Request $request) {
    return 'Signup data received: ' . $request->input('email');
});

Route::post('/login', function (Request $request) {
    return 'Login data received: ' . $request->input('email');
});
