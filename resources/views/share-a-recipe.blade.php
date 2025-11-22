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
                <h1 class="page-title">{{ $editMode ? 'Edit Recipe' : 'Share a Recipe' }}</h1>

                <div class="form-preview-wrapper">
                    <form id="recipeForm" class="recipe-form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-top">
                            <div class="image-upload">
                                <label for="imageInput" class="image-label">
                                    @if($editMode && $recipe && $recipe->image)
                                        @php
                                            $imgPath = null;
                                            if (str_starts_with($recipe->image, 'assets/') || str_starts_with($recipe->image, 'http')) {
                                                $imgPath = asset($recipe->image);
                                            } else {
                                                $imgPath = asset('storage/' . $recipe->image);
                                            }
                                        @endphp
                                        <div id="imagePreview" class="image-preview">
                                            <img src="{{ $imgPath }}" alt="Current recipe image">
                                        </div>
                                    @else
                                        <div id="imagePreview" class="image-preview">Tap or click to add photo</div>
                                    @endif
                                    <input type="file" id="imageInput" name="image" accept="image/*" hidden />
                                    <input type="hidden" id="imageUrl" name="image_url" value="" />
                                    <input type="hidden" id="removeImage" name="remove_image" value="0" />
                                </label>
                                <div class="image-controls">
                                    <button type="button" id="addUrlBtn" class="image-control-btn">Add URL</button>
                                    <button type="button" id="removeImageBtn" class="image-control-btn remove" style="display: none;">Remove Image</button>
                                </div>
                            </div>

                            <div class="text-inputs">
                                <input type="text" id="recipeName" name="title" placeholder="Recipe Name" value="{{ $editMode && $recipe ? $recipe->title : '' }}" required />
                                <input type="text" id="category" name="categories" placeholder="Category" value="{{ $editMode && $recipe && $recipe->categories ? implode(', ', $recipe->categories) : '' }}" />
                                
                                <div class="time-inputs">
                                    <input type="number" name="prep_time" placeholder="Prep Time (min)" value="{{ $editMode && $recipe ? $recipe->prep_time : '' }}">
                                    <input type="number" name="cook_time" placeholder="Cook Time (min)" value="{{ $editMode && $recipe ? $recipe->cook_time : '' }}">
                                    <input type="number" name="servings" placeholder="Servings" value="{{ $editMode && $recipe ? $recipe->servings : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-bottom">
                            <div class="ingredients-section">
                                <h3>Ingredients</h3>
                                <ul id="ingredientsList">
                                    @if($editMode && $recipe && $recipe->ingredients)
                                        @foreach($recipe->ingredients as $ingredient)
                                            <li>
                                                <span>{{ $ingredient }}</span>
                                                <button type="button" class="material-symbols-outlined" aria-label="Remove ingredient">close</button>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="input-add">
                                    <input type="text" id="ingredientInput" placeholder="Add ingredient..." />
                                    <button type="button" id="addIngredientBtn">+</button>
                                </div>
                            </div>

                            <div class="steps-section">
                                <h3>Steps</h3>
                                <ol id="stepsList">
                                    @if($editMode && $recipe && $recipe->instructions)
                                        @foreach($recipe->instructions as $instruction)
                                            <li>
                                                <span>{{ $instruction }}</span>
                                                <button type="button" class="material-symbols-outlined" aria-label="Remove step">close</button>
                                            </li>
                                        @endforeach
                                    @endif
                                </ol>
                                <div class="input-add">
                                    <input type="text" id="stepInput" placeholder="Add step..." />
                                    <button type="button" id="addStepBtn">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="description-section">
                            <h3>Description</h3>
                            <textarea name="description" placeholder="Describe your recipe...">{{ $editMode && $recipe ? $recipe->description : '' }}</textarea>
                        </div>

                        <button type="submit" class="submit-btn">{{ $editMode ? 'UPDATE RECIPE' : 'CREATE A RECIPE' }}</button>
                    </form>

                    <div class="preview-sidebar">
                        <div class="preview-sticky">
                            <h3>Recipe Preview</h3>
                            <div class="recipe-card-preview">
                                <div class="recipe-image-wrapper">
                                    <img id="previewImage" src="{{ asset('assets/food/no-image.jpg') }}" alt="Recipe preview" class="recipe-image">
                                    <div class="recipe-overlay">
                                        <span class="recipe-time">
                                            <span class="material-symbols-outlined">schedule</span>
                                            <span id="previewTime">0 min</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="recipe-content">
                                    <h3 class="recipe-title" id="previewTitle">Recipe Name</h3>
                                    <p class="recipe-description" id="previewDescription">A delicious recipe waiting for you to try!</p>
                                    <div class="recipe-categories" id="previewCategories"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>

