<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Recipe;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Recipe $recipe)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::updateOrCreate(
            ['user_id' => $request->user()->id, 'recipe_id' => $recipe->id],
            ['rating' => $data['rating']]
        );

        // Recalculate summary fields and save on recipe
        $avg = $recipe->ratings()->avg('rating');
        $count = $recipe->ratings()->count();

        $recipe->average_rating = $avg;
        $recipe->ratings_count = $count;
        $recipe->save();

        return response()->json([
            'success' => true,
            'rating' => $rating->rating,
            'average' => round($avg, 2),
            'count' => $count,
        ]);
    }
}
