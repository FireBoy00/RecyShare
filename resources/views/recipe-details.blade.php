<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/recipe-detail.css', 'resources/js/recipe-detail.js'])
    <title>{{ $recipe->title }} | RecyShare</title>
</head>
<body>
    <!-- Site Header -->
    <header>
        <x-navbar currentPage="recipes" />
    </header>
    <main id="recipeDetailContainer">
        <section class="recipe-hero">
            <div class="hero-image-container">
                <img src="{{ $recipe->image ? asset($recipe->image) : asset('assets/food/no-image-no-text.jpg') }}" alt="{{ $recipe->title }}" class="recipe-image" id="recipeImage">
                <div class="action-buttons">
                    @auth
                        <form id="favoriteForm" class="favorite-form">
                            @csrf
                            <button type="button" id="favoriteBtn" class="favorite-btn {{ $isFavorited ? 'favorited' : '' }}" data-recipe-id="{{ $recipe->id }}">
                                <span class="material-symbols-outlined favorite-icon">
                                    {{ $isFavorited ? 'favorite' : 'favorite_border' }}
                                </span>
                            </button>
                        </form>
                        <form id="shareForm" class="share-form">
                            @csrf
                            <button type="button" id="shareBtn" class="share-btn">
                                <span class="material-symbols-outlined">share</span>
                            </button>
                        </form>
                    @else
                        <form id="shareForm" class="share-form">
                            @csrf
                            <button type="button" id="shareBtn" class="share-btn">
                                <span class="material-symbols-outlined">share</span>
                            </button>
                        </form>
                    @endauth
                </div>
                <div id="sharePopup" class="share-popup">
                    <p>Copy link to share:</p>
                    <div class="share-link-container">
                        <input type="text" id="shareLink" readonly value="{{ url()->current() }}">
                        <button id="copyBtn" type="button">
                            <span class="material-symbols-outlined">content_copy</span>
                        </button>
                    </div>
                </div>
                <div id="favoritePopup" class="favorite-popup">Recipe saved to favorites!</div>
                <div class="hero-overlay">
                    <h1 class="recipe-title" id="recipeTitle">{{ $recipe->title }}</h1>
                </div>
            </div>
        </section>
        <section class="recipe-meta-container">
            <div class="author-info">
                <a href="{{ route('profile', $recipe->user) }}" class="author-info">
                @if($recipe->user && $recipe->user->profile_image)
                    <img src="{{ asset($recipe->user->profile_image) }}" alt="{{ $recipe->user->display_name }}" class="author-avatar">
                @else
                    <div class="author-avatar author-avatar-placeholder">
                        <span class="material-symbols-outlined">account_circle</span>
                    </div>
                @endif
                </a>
                <div class="author-text">
                    <a href="{{ route('profile', $recipe->user) }}">
                    <p class="author-handle">{{ '@' . ($recipe->user->username ?? 'unknown') }}</p>
                    <p class="author-display-name">{{ $recipe->user->display_name ?? 'Unknown User' }}</p>
                    <p class="recipe-count">{{ $recipe->user->recipes->count() ?? 0 }} recipes</p>
                    </a>
                </div>
            </div>
            <div class="meta-details">
                <div class="meta-item">
                    <span class="material-symbols-outlined icon">schedule</span>
                    <div class="meta-text">
                        <strong>Preparation time</strong>
                        <p>@formatTime($recipe->prep_time ?? 30)</p>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="material-symbols-outlined icon">skillet</span>
                    <div class="meta-text">
                        <strong>Cooking time</strong>
                        <p>@formatTime($recipe->cook_time ?? 30)</p>
                    </div>
                </div>
                <div class="meta-item">
                    <span class="material-symbols-outlined icon">restaurant</span>
                    <div class="meta-text">
                        <strong>Servings Number</strong>
                        <p>{{ $recipe->servings ?? 4 }} Servings</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="recipe-content-main">
            <div class="ingredients-section">
                <h2 class="ingredients-title">Ingredients</h2>
                <div class="ingredients-list-container">
                    <ul class="ingredients-list">
                        @if($recipe->ingredients && is_array($recipe->ingredients))
                            @foreach($recipe->ingredients as $ingredient)
                                <li>{{ $ingredient }}</li>
                            @endforeach
                        @else
                            <li>No ingredients listed</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="instructions-section">
                <h2 class="instructions-title">Instructions</h2>
                <ol class="instructions-list">
                    @if($recipe->instructions && is_array($recipe->instructions))
                        @foreach($recipe->instructions as $instruction)
                            <li>{{ $instruction }}</li>
                        @endforeach
                    @else
                        <li>No instructions provided</li>
                    @endif
                </ol>
            </div>
        </section>
        <section class="categories-section">
            <h2 class="categories-title">Categories</h2>
            <div class="category-tags">
                @if($recipe->categories && is_array($recipe->categories) && count($recipe->categories) > 0)
                    @foreach($recipe->categories as $category)
                        <span class="category-tag">{{ $category }}</span>
                    @endforeach
                @else
                    <span class="category-tag">Homemade</span>
                @endif
            </div>
        </section>
        <section class="comments-section">
            <h2 class="comments-title">Comments</h2>
            @auth
                <form class="comment-form" action="{{ route('recipes.comment', $recipe->id) }}" method="POST">
                    @csrf
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset(auth()->user()->profile_image) }}" class="user-avatar" alt="{{ auth()->user()->display_name }}">
                    @else
                        <div class="user-avatar user-avatar-placeholder">
                            <span class="material-symbols-outlined">account_circle</span>
                        </div>
                    @endif
                    <input type="text" name="comment" placeholder="Add a comment" class="comment-input" required>
                    <button type="submit" class="comment-button">
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </form>
            @else
                <p class="login-prompt">Please <a href="{{ route('login') }}">log in</a> to leave a comment.</p>
            @endauth
            <div class="comment-thread">
                @foreach ($comments as $comment)
                    <div class="comment-box">
                        @if($comment->user && $comment->user->profile_image)
                            <img src="{{ asset($comment->user->profile_image) }}" class="user-avatar" alt="{{ $comment->user->display_name }}">
                        @else
                            <div class="user-avatar user-avatar-placeholder">
                                <span class="material-symbols-outlined">account_circle</span>
                            </div>
                        @endif
                        <div class="comment-details">
                            <p class="comment-author">{{ $comment->user->display_name ?? $comment->user->username ?? 'Unknown' }}</p>
                            <p class="comment-text">{{ $comment->content }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</body>
</html>
