<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //Keep for future use

class RecipeController extends Controller
{
    /**
     * Display a listing of recipes.
     */
    public function index()
    {
        return view('recipes');
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create()
    {
        return view('share-a-recipe');
    }

    /**
     * Display the specified recipe.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // You can fetch the recipe by id here, e.g.:
        // $recipe = Recipe::findOrFail($id);
        // return view('recipe-details', compact('recipe'));

        return view('recipe-details', ['id' => $id]);
    }
}
