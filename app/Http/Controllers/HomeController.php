<?php

namespace App\Http\Controllers;
use App\Models\Recipe;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Get 6 most recently shared recipes
        $recentRecipes = Recipe::with('user')
            ->latest()
            ->take(6)
            ->get();

        // Get 10 random users who have recipes
        $randomUsers = User::has('recipes')
            ->inRandomOrder()
            ->take(10)
            ->get();

        return view('home', compact('recentRecipes', 'randomUsers'));
    }
}
