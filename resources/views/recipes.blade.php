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
            <h1>Showing {{ $recipes->lastItem() - $recipes->firstItem()+1}} out of {{$recipes->total()}} recipes</h1>
            <div class="recipes-list" id="recipesList">
                @foreach ($recipes as $recipe)
                    <x-recipe-card :recipe="$recipe" />
                @endforeach
            </div>
            <div class="pagination-container">
                {{ $recipes->links('pagination::default') }}
            </div>
        </div>
    </header>
</body>

</html>
