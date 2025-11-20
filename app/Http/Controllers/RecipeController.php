<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\Favorite;
use Illuminate\Support\Facades\Storage;


class RecipeController extends Controller
{
    /**
     * Delete image file from storage if it's an uploaded path.
     * Skips deletion for asset and external HTTP paths.
     */
    private function deleteImageIfUploaded($imagePath)
    {
        if ($imagePath && !str_starts_with($imagePath, 'assets/') && !str_starts_with($imagePath, 'http')) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * Display a listing of recipes.
     */
    public function index()
    {
        $recipes = Recipe::with('user')->latest()->get();
        return view('recipes', compact('recipes'));
    }

    /**
     * Show the form for creating a new recipe or editing an existing one.
     */
    public function create(Request $request)
    {
        $recipe = null;
        $editMode = false;

        if ($request->has('edit')) {
            $recipeId = $request->query('edit');
            $recipe = Recipe::find($recipeId);

            if ($recipe && $recipe->user_id === auth()->id()) {
                $editMode = true;
            } else {
                return redirect()->route('recipes.create')->with('error', 'Recipe not found or unauthorized');
            }
        }
        
        return view('share-a-recipe', compact('recipe', 'editMode'));
    }

    /**
     * Store a newly created recipe in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to share a recipe.'
            ], 401);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prep_time' => 'nullable|integer|min:0',
            'cook_time' => 'nullable|integer|min:0',
            'servings' => 'nullable|integer|min:1',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'string|max:500',
            'instructions' => 'nullable|array',
            'instructions.*' => 'string|max:1000',
            'categories' => 'nullable|array',
            'categories.*' => 'string|max:100',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('recipes', 'public');
            }

            $recipe = Recipe::create([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'description' => $validated['description'] ?? '',
                'image' => $imagePath,
                'prep_time' => $validated['prep_time'] ?? 0,
                'cook_time' => $validated['cook_time'] ?? 0,
                'servings' => $validated['servings'] ?? 1,
                'ingredients' => $validated['ingredients'] ?? [],
                'instructions' => $validated['instructions'] ?? [],
                'categories' => $validated['categories'] ?? [],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Recipe created successfully!',
                'recipe_id' => $recipe->id,
                'redirect_url' => route('recipes.show', $recipe->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating recipe: ' . $e->getMessage()
            ], 500);
        }
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

    /**
     * Remove the specified recipe from storage.
     */
    public function destroy(Recipe $recipe)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
        }

        if ($recipe->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        try {
            $this->deleteImageIfUploaded($recipe->image);
            $recipeId = $recipe->id;
            $recipe->delete();

            return response()->json(['success' => true, 'message' => 'Recipe deleted', 'recipe_id' => $recipeId]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting recipe: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing recipe.
     */
    public function update(Request $request, Recipe $recipe)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
        }

        if ($recipe->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prep_time' => 'nullable|integer|min:0',
            'cook_time' => 'nullable|integer|min:0',
            'servings' => 'nullable|integer|min:1',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'string|max:500',
            'instructions' => 'nullable|array',
            'instructions.*' => 'string|max:1000',
            'categories' => 'nullable|array',
            'categories.*' => 'string|max:100',
        ]);

        try {
            $imagePath = $recipe->image;
            if ($request->hasFile('image')) {
                $this->deleteImageIfUploaded($recipe->image);
                $imagePath = $request->file('image')->store('recipes', 'public');
            }

            $recipe->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? $recipe->description,
                'image' => $imagePath,
                'prep_time' => $validated['prep_time'] ?? $recipe->prep_time,
                'cook_time' => $validated['cook_time'] ?? $recipe->cook_time,
                'servings' => $validated['servings'] ?? $recipe->servings,
                'ingredients' => $validated['ingredients'] ?? $recipe->ingredients,
                'instructions' => $validated['instructions'] ?? $recipe->instructions,
                'categories' => $validated['categories'] ?? $recipe->categories,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Recipe updated successfully!',
                'recipe_id' => $recipe->id,
                'redirect_url' => route('recipes.show', $recipe->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating recipe: ' . $e->getMessage()
            ], 500);
        }
    }
}
