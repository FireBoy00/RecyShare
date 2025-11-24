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
            <nav class="navbar">
                <div class="left">
                    <div class="logo">
                        <img src="{{ asset('assets/logos/recyshare-logo-no-text.png') }}" alt="RecyShare Logo">
                        <h3>RecyShare</h3>
                    </div>
                </div>
                <div class="right">
                    <ul class="nav-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li class="active"><a href="{{ route('recipes.index') }}">Recipes</a></li>
                        <li class="dropdown">
                            <span class="dropbtn">Categories</span>
                            <div class="dropdown-content">
                                <a href="#">Breakfast</a>
                                <a href="#">Lunch</a>
                                <a href="#">Dinner</a>
                                <a href="#">Dessert</a>
                                <a href="#">Vegan</a>
                                <a href="#">Gluten-Free</a>
                            </div>
                        </li>
                    </ul>
                    <div class="account">
                        <img class="icon"
                             src="{{ asset('assets/icons/account_circle_48dp_000000_FILL0_wght300_GRAD200_opsz48.png') }}"
                             alt="Account">
                    </div>
                </div>
            </nav>
        </header>

        <main class="recipes-page">
            {{-- Big green header --}}
            <section class="recipes-header">
                <div class="recipes-header-controls">
                    <button type="button" class="back-button" aria-label="Go back">
                        ←
                    </button>

                    <div class="search-bar">
                        <img class="icon"
                            src="{{ asset('assets/icons/search_48dp_000000_FILL0_wght300_GRAD200_opsz48.png') }}"
                            alt="Search">
                        <input type="search" id="searchBar" placeholder="Search">
                    </div>

                    <button type="button" class="filters-toggle" id="filtersToggle">
                        Filters
                    </button>
                </div>

                {{-- Filters panel (JS toggles hidden) --}}
                <section class="recipes-filters" id="recipesFilters" hidden>
                    <h2>Filter by:</h2>
                    <ul>
                        <li>Categories</li>
                        <li>Type of food</li>
                        <li>Cooking time</li>
                    </ul>
                </section>
            </section>


            {{-- Add New Recipe bar --}}
            <section class="add-recipe-section">
                <button type="button" class="add-recipe-button">
                    Add New Recipe
                </button>
            </section>

            {{-- Cards container --}}
            <section class="recipes-section">
                <div class="recipes-container">
                    <div class="recipes-toolbar">
                        <button type="button"
                                class="view-toggle"
                                id="viewToggle"
                                aria-label="Toggle card or list view">
                            ☰
                        </button>
                    </div>

                    <div class="recipes-list" id="recipesList">
                        <!-- Recipe items will be dynamically inserted here -->
                    </div>
                </div>
            </section>
        </main>

        {{-- Template for dynamically generated recipe cards --}}
        <template id="recipeTemplate">
            <div class="recipe-card">
                <div class="recipe-image" id="recipeImage">
                    <img src="https://placehold.co/250x160/025b3f/2ec68a/?text=Sample+Recipe\n- 1 -"
                         alt="Sample Recipe">
                </div>
                <div class="recipe-content">
                    <h3 class="recipe-title" id="recipeTitle">Sample Recipe Title</h3>
                    <p class="recipe-description" id="recipeDescription">
                        A brief description of the sample recipe.
                    </p>
                    <div class="btn">
                        <a id="recipeLink" href="">View Recipe</a>
                        {{-- Disabled view recipe functionality for now --}}
                    </div>
                </div>
            </div>
        </template>

        {{-- <script>
            const recipeDetailsRoute = "{{ route('recipes.show') }}";
        </script> --}}
    </body>
</html>
