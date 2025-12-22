<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;

class CategoryController extends Controller
{
    public function show($category)
    {
        $recipes = Recipe::whereJsonContains('categories', $category)
            ->paginate(12);

        return view('categories.show', [
            'category' => $category,
            'recipes' => $recipes,
        ]);
    }
}
