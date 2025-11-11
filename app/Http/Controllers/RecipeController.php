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
        $recipes = Recipe::with('user')->latest()->get();
        return view('recipes', compact('recipes'));
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
        $recipe = Recipe::with('user')->findOrFail($id);
        $comments = $recipe->comments()->with('user')->latest()->get();
        $isFavorited = false;

        if (auth()->check()) {
            $isFavorited = $recipe->favorites()->where('user_id', auth()->id())->exists();
        }

        return view('recipe-details', compact('recipe', 'comments', 'isFavorited'));
    }

    public function addComment(Request $request, Recipe $recipe)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to comment.'
            ], 401);
        }

        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment = Comment::create([
            'recipe_id' => $recipe->id,
            'user_id' => auth()->id(),
            'content' => $request->comment
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'author_name' => $comment->user->display_name,
                'username' => $comment->user->username,
                'profile_image' => $comment->user->profile_image ? asset($comment->user->profile_image) : null,
                'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    public function toggleFavorite(Recipe $recipe)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to favorite recipes.'
            ], 401);
        }

        $userId = auth()->id();

        $favorite = Favorite::where('recipe_id', $recipe->id)
            ->where('user_id', $userId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
        } else {
            Favorite::create([
                'recipe_id' => $recipe->id,
                'user_id' => $userId
            ]);
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'isFavorited' => $isFavorited
        ]);
    }
}
