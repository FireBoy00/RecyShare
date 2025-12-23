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

            {{--FILTER UI (INDIVIDUAL EXTENSION) --}}
            <form method="GET"
                action="{{ route('recipes.index') }}"
                style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">

                <label for="max_time">Max total time:</label>

                <select name="max_time"
                        id="max_time"
                        onchange="this.form.submit()">
                    <option value="">Any</option>
                    <option value="15" {{ request('max_time') == '15' ? 'selected' : '' }}>≤ 15 min</option>
                    <option value="30" {{ request('max_time') == '30' ? 'selected' : '' }}>≤ 30 min</option>
                    <option value="45" {{ request('max_time') == '45' ? 'selected' : '' }}>≤ 45 min</option>
                    <option value="60" {{ request('max_time') == '60' ? 'selected' : '' }}>≤ 60 min</option>
                </select>

                {{-- reserved space: link appears without layout shift --}}
                <span style="min-width: 90px;">
                    @if(request('max_time'))
                        <a href="{{ route('recipes.index') }}" style="font-size: 0.9rem;">
                            Clear filter
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
                        <a href="{{ route('recipes.index') }}">Clear filter</a>
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
