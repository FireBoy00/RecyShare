<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/recipes.css', 'resources/js/recipes.js'])
        <title>RecyShare - Recipes</title>
    </head>

    <body>
        <header>
            <x-navbar currentPage="recipes" />
            <div class="recipes-container">
                <h1>Recipes</h1>
                <div class="recipes-list" id="recipesList">
                    <!-- Recipe items will be dynamically inserted here -->
                </div>
            </div>
        </header>
        <template id="recipeTemplate">
            <div class="recipe-card">
                <div class="recipe-image" id="recipeImage">
                    <img src="https://placehold.co/250x160/025b3f/2ec68a/?text=Sample+Recipe\n- 1 -" alt="Sample Recipe">
                </div>
                <h3 class="recipe-title" id="recipeTitle">Sample Recipe Title</h3>
                <p class="recipe-description" id="recipeDescription">A brief description of the sample recipe.</p>
                <div class="btn">
                    <a id="recipeLink" href="">View Recipe</a>
                </div>
            </div>
        </template>
    </body>
</html>