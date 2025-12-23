<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/recipes.css'])
    <title>{{ $category }} Recipes</title>
</head>

<body>
<header>
    <x-navbar currentPage="categories" />

    <div class="recipes-container">
        <h1>We have {{ $recipes->count() }} {{ $category }} recipes.</h1>

        <div class="recipes-list">
            @foreach($recipes as $recipe)
                <x-recipe-card :recipe="$recipe" :fullPage="false" />
            @endforeach
        </div>
    </div>
</header>
</body>
</html>

