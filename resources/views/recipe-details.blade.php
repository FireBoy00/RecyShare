<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/recipe-detail.css', 'resources/js/recipe-detail.js'])
    <title>RecyShare</title>
</head>
<body>
    <!-- Site Header -->
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
                <div class="search-bar">
                    <img class="icon" src="{{ asset('assets/icons/search_48dp_000000_FILL0_wght300_GRAD200_opsz48.png') }}" alt="Search Icon">
                    <input type="search" id="searchBar" placeholder="Search...">
                </div>
                <div class="account">
                    <img class="icon" src="{{ asset('assets/developers/Gabija.jpg') }}" alt="Account Icon">
                </div>
            </div>
        </nav>
    </header>
    <main id="recipeDetailContainer">
        <section class="recipe-hero">
            <div class="hero-image-container">
                <img src="{{ asset('assets/food/Monte-Cristo-Sandwich-1664x834-1.jpg') }}" alt="Monte Cristo Sandwich" class="recipe-image" id="recipeImage">
                <div class="hero-overlay">
                    <h1 class="recipe-title" id="recipeTitle">Monte Cristo Sandwich</h1>
                    <div class="share-icons">
                        <img src="{{ asset('assets/icons/heart_plus_24dp_000000_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Save Icon" class="icon save-icon">
                        <img src="{{ asset('assets/icons/share_24dp_000000_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Share Icon" class="icon share-icon">
                    </div>
                </div>
            </div>
        </section>
        <section class="recipe-meta-container">
            <div class="author-info">
                <img src="{{ asset('assets/food/Monte-Cristo-Sandwich-1664x834-1.jpg') }}" alt="Author Avatar" class="author-avatar">
                <div class="author-text">
                    <p class="author-handle">@BestChefAlive</p>
                    <p class="recipe-count">20 recipes</p>
                </div>
            </div>
            <div class="meta-details">
                <div class="meta-item">
                    <img src="{{ asset('assets/icons/blender_24dp_000000_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Preparation Time Icon" class="icon">
                    <p><strong>Preparation time</strong> 30 minutes</p>
                </div>
                <div class="meta-item">
                    <img src="{{ asset('assets/icons/skillet_24dp_000000_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Cooking Time Icon" class="icon">
                    <p><strong>Cooking time</strong> 30 min to 1 hour</p>
                </div>
                <div class="meta-item">
                    <img src="{{ asset('assets/icons/hand_meal_24dp_000000_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Servings Icon" class="icon">
                    <p><strong>Servings Number</strong> 4 Servings</p>
                </div>
            </div>
        </section>
        <section class="recipe-content-main">
            <div class="ingredients-section">
                <h2 class="ingredients-title">Ingredients</h2>
                <div class="ingredients-list-container">
                    <ul class="ingredients-list">
                        <li>8 slices bread (challah)</li>
                        <li>4 tsp honey dijon mustard</li>
                        <li>8 slices swiss cheese</li>
                        <li>8 slices turkey</li>
                        <li>8 slices ham</li>
                        <li>3 eggs</li>
                        <li>2 tbsp flour</li>
                        <li>1 tbsp melted butter</li>
                        <li>Salt & pepper</li>
                        <li>2 tbsp milk</li>
                        <li>Powdered sugar</li>
                        <li>Raspberry preserves</li>
                    </ul>
                </div>
            </div>
            <div class="instructions-section">
                <h2 class="instructions-title">Instructions</h2>
                <ol class="instructions-list">
                    <li>Heat oven to 425°F.</li>
                    <li>Butter a baking sheet.</li>
                    <li>Spread mustard on bread slices.</li>
                    <li>Layer cheese, ham, turkey, cheese.</li>
                    <li>Whisk eggs, flour, butter, salt, pepper.</li>
                    <li>Blend in milk.</li>
                    <li>Dip sandwiches in egg mix.</li>
                    <li>Bake 8-10 min each side until golden.</li>
                    <li>Dust with powdered sugar & serve with preserves.</li>
                </ol>
            </div>
        </section>
        <section class="categories-section">
            <h2 class="categories-title">Categories</h2>
            <div class="category-tags">
                <span class="category-tag">French</span>
                <span class="category-tag">Breakfast</span>
                <span class="category-tag">Brunch</span>
            </div>
        </section>
        <section class="comments-section">
            <h2 class="comments-title">Comments</h2>
            <div class="comment-form">
                <img src="{{ asset('assets/developers/Gabija.jpg') }}" alt="User Avatar" class="user-avatar">
                <input type="text" placeholder="Add a comment" class="comment-input">
                <button class="comment-button">Comment</button>
            </div>
            <div class="comment-thread">
                <div class="comment-box">
                    <img src="{{ asset('assets/developers/Gabija.jpg') }}" alt="User Avatar" class="user-avatar">
                    <div class="comment-details">
                        <p class="comment-author">@GabijaNotFromHere</p>
                        <p class="comment-text">Nice recipe, tried it - and now I make it at least once per week!</p>
                        <div class="comment-actions">
                            <span class="likes"><img src="{{ asset('assets/icons/thumb_up_24dp_000000_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Like Button" class="icon"></span>
                            <span class="reply"><img src="{{ asset('assets/icons/thumb_down_24dp_000000_FILL0_wght400_GRAD0_opsz24.png') }}" alt="Dislike Button" class="icon"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>