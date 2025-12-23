<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/recipe-card.css', 'resources/js/recipe-card.js'])
    @vite(['resources/css/recipes.css', 'resources/js/recipes.js'])

    <title>RecyShare - Recipes</title>
</head>

<body>
<header>
    <x-navbar currentPage="recipes" />

    <div class="recipes-container">
        <h1>
            Showing {{ $recipes->count() }} out of {{ $recipes->total() }} recipes
        </h1>

        {{-- FILTER UI (INDIVIDUAL EXTENSION) --}}
        <form method="GET"
              action="{{ route('recipes.index') }}"
              class="recipes-filters"
              style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">

            {{-- Max total time --}}
            <label>
                Max total time:
                <select name="max_time" onchange="this.form.submit()">
                    <option value="">Any</option>
                    <option value="15" @selected(request('max_time') == 15)>≤ 15 min</option>
                    <option value="30" @selected(request('max_time') == 30)>≤ 30 min</option>
                    <option value="45" @selected(request('max_time') == 45)>≤ 45 min</option>
                    <option value="60" @selected(request('max_time') == 60)>≤ 60 min</option>
                </select>
            </label>

            {{-- Minimum servings --}}
            <label>
                Servings:
                <select name="servings" onchange="this.form.submit()">
                    <option value="">Any</option>
                    <option value="1" @selected(request('servings') == 1)>1+</option>
                    <option value="2" @selected(request('servings') == 2)>2+</option>
                    <option value="4" @selected(request('servings') == 4)>4+</option>
                    <option value="6" @selected(request('servings') == 6)>6+</option>
                </select>
            </label>

            {{-- Clear filters (no layout shift) --}}
            <span style="min-width: 110px;">
                @if(request('max_time') || request('servings'))
                    <a href="{{ route('recipes.index') }}" style="font-size: 0.9rem;">
                        Clear filters
                    </a>
                @endif
            </span>
        </form>

        {{-- RECIPES LIST --}}
        <div class="recipes-list" id="recipesList">
            @if($recipes->count())
                @foreach ($recipes as $recipe)
                    <x-recipe-card :recipe="$recipe" />
                @endforeach
            @else
                <div class="empty-state">
                    <p>No recipes match your filters.</p>
                    <a href="{{ route('recipes.index') }}">Clear filters</a>
                </div>
            @endif
        </div>

        <div class="pagination-container">
            {{ $recipes->links() }}
        </div>
    </div>
</header>
</body>

</html>
