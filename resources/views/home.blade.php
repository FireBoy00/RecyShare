<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/home.css', 'resources/js/home.js'])
        <title>RecyShare</title>
    </head>

    <body>
        <header>
            <x-navbar currentPage="home" />
            <div class="hero">
                <h1>Your Kitchen, Your Story.<br>
                    Share It With the World Today!</h1>
                <a href="{{ route('recipes.create') }}" class="btn" id="shareBtn">Share a Recipe</a>
            </div>
        </header>
        
        <main>
            <!-- Recently Shared Recipes Section -->
            <section class="recently-shared">
                <h2>Recently Shared Recipes</h2>
                <div class="recipes-grid">
                    @forelse($recentRecipes as $recipe)
                        <x-recipe-card :recipe="$recipe" />
                    @empty
                        <p class="no-content">No recipes shared yet. Be the first to share!</p>
                    @endforelse
                </div>
            </section>

            <!-- Find Recipes From Users Section -->
            <section class="find-users">
                <h2>Find Recipes From...</h2>
                <div class="users-carousel">
                    <button class="carousel-btn prev-btn" aria-label="Previous users">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <div class="users-container">
                        @forelse($randomUsers as $user)
                            <a href="{{ route('profile', $user) }}" class="user-item">
                                <div class="user-avatar-circle">
                                    @if($user->profile_image)
                                        <img src="{{ asset($user->profile_image) }}" alt="{{ $user->display_name }}">
                                    @else
                                        <div class="user-avatar-placeholder">
                                            <span class="material-symbols-outlined">account_circle</span>
                                        </div>
                                    @endif
                                </div>
                                <span class="user-name">{{ $user->display_name ?? $user->username }}</span>
                            </a>
                        @empty
                            <p class="no-content">No users to display yet.</p>
                        @endforelse
                    </div>
                    <button class="carousel-btn next-btn" aria-label="Next users">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </section>
        </main>
    </body>
</html>