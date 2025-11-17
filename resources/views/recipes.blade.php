<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/recipes.css', 'resources/js/recipes.js'])
        <title>RecyShare - Recipes</title>
    </head>

    <body>
        <header>
            <x-navbar currentPage="recipes" />
            <div class="recipes-container">
                <h1>We have {{ $recipes->count() }} recipes</h1>
                <div class="recipes-list" id="recipesList">
                    @foreach($recipes as $recipe)
                        <div class="recipe-card" data-recipe-id="{{ $recipe->id }}">
                            <div class="recipe-image-wrapper">
                                <img src="{{ $recipe->image ? asset($recipe->image) : asset('assets/food/no-image.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image">
                                <div class="recipe-overlay">
                                    <span class="recipe-time">
                                        <span class="material-symbols-outlined">schedule</span>
                                        @formatTime(($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0))
                                    </span>
                                    @auth
                                        @php
                                            $isFavorited = $recipe->favorites()->where('user_id', auth()->id())->exists();
                                        @endphp
                                        <button class="recipe-favorite-btn {{ $isFavorited ? 'favorited' : '' }}" data-recipe-id="{{ $recipe->id }}">
                                            <span class="material-symbols-outlined">
                                                {{ $isFavorited ? 'favorite' : 'favorite_border' }}
                                            </span>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                            <div class="recipe-content">
                                <h3 class="recipe-title">{{ $recipe->title }}</h3>
                                <p class="recipe-description">
                                    {{ $recipe->description ?? 'A delicious recipe waiting for you to try!' }}
                                </p>
                                @if($recipe->categories && is_array($recipe->categories) && count($recipe->categories) > 0)
                                    <div class="recipe-categories">
                                        @foreach(array_slice($recipe->categories, 0, 3) as $category)
                                            <span class="category-tag-small">{{ $category }}</span>
                                        @endforeach
                                    </div>
                                @endif
                
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn">View Recipe</a>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </header>
    </body>
</html>
