<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\Favorite;


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
        $recipe = Recipe::findOrFail($id);
        $comments = $recipe->comments()->latest()->get();
        $userIdentifier = session()->getId();
        $isFavorited = $recipe->favorites()->where('user_identifier', $userIdentifier)->exists();

        return view('recipe-details', compact('recipe', 'comments', 'isFavorited'));
    }

    public function addComment(Request $request, Recipe $recipe)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment = Comment::create([
            'recipe_id' => $recipe->id,
            'author_name' => 'Guest', // TODO: auth later
            'content' => $request->comment
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    public function toggleFavorite(Recipe $recipe)
    {
        $userIdentifier = session()->getId(); // Using session ID as temporary user identifier

        $favorite = Favorite::where('recipe_id', $recipe->id)
            ->where('user_identifier', $userIdentifier)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
        } else {
            Favorite::create([
                'recipe_id' => $recipe->id,
                'user_identifier' => $userIdentifier
            ]);
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'isFavorited' => $isFavorited
        ]);
    }
}
