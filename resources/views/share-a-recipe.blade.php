<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/share-a-recipe.css', 'resources/js/share-a-recipe.js'])
        <title>Share a Recipe – RecyShare</title>
    </head>

    <body>
        <header>
            <x-navbar currentPage="recipes" />
        </header>

        <main class="container">
            <section class="form-section">
                <h1 class="page-title">Share a Recipe</h1>

                <form id="recipeForm" class="recipe-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-top">
                        <div class="image-upload">
                            <label for="imageInput" class="image-label">
                                <div id="imagePreview" class="image-preview">Tap or click to add photo</div>
                                <input type="file" id="imageInput" name="image" accept="image/*" hidden />
                            </label>
                        </div>

                        <div class="text-inputs">
                            <input type="text" id="recipeName" name="title" placeholder="Recipe Name" required />
                            <input type="text" id="category" name="categories" placeholder="Category" />
                            
                            <div class="time-inputs">
                                <input type="number" name="prep_time" placeholder="Prep Time (min)">
                                <input type="number" name="cook_time" placeholder="Cook Time (min)">
                                <input type="number" name="servings" placeholder="Servings">
                            </div>
                        </div>
                    </div>

                    <div class="form-bottom">
                        <div class="ingredients-section">
                            <h3>Ingredients</h3>
                            <ul id="ingredientsList"></ul>
                            <div class="input-add">
                                <input type="text" id="ingredientInput" placeholder="Add ingredient..." />
                                <button type="button" id="addIngredientBtn">+</button>
                            </div>
                        </div>

                        <div class="steps-section">
                            <h3>Steps</h3>
                            <ol id="stepsList"></ol>
                            <div class="input-add">
                                <input type="text" id="stepInput" placeholder="Add step..." />
                                <button type="button" id="addStepBtn">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="description-section">
                        <h3>Description</h3>
                        <textarea name="description" placeholder="Describe your recipe..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">CREATE A RECIPE</button>
                </form>
            </section>
        </main>
    </body>
</html>

