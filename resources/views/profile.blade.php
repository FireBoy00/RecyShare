<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/profile.css'])
        @vite(['resources/css/recipes.css'])
        <title>RecyShare</title>
    </head>

    <body>
        <!-- Site Header -->
        <header>
            <x-navbar currentPage="" />
        </header>

        <!-- Main Page Content -->
        
        <main> 
             <section class="user_circle">
            <div class="user-info">
                <article class="user">
                    @if ($user->profile_image)
                        <img src="{{ asset($user->profile_image) }}">
                    @else
                        <img src="https://placehold.co/200x200?text=No+Image">
                    @endif
                </article>
                <div class="user-details">
                    <h2 class="username">{{ '@' . $user->username }}</h2>
                    <p>{{ $recipes->count() }} Recipes</p>
                </div>
            </div>
            <section class="hero-bio">
                <p>{{ $user->bio ?? 'No bio available.' }}</p>
            </section>
        </section>
        <section class="shared-recipes">
            <h2 class="text">Shared recipes</h2>

            <div class="recipes-list" id="profileRecipesList">
                @forelse($recipes as $recipe)
                    <div class="recipe-card" data-recipe-id="{{ $recipe->id }}">
                        <div class="recipe-image-wrapper">
                            <img src="{{ $recipe->image ? asset($recipe->image) : asset('assets/food/no-image.jpg') }}" 
                                alt="{{ $recipe->title }}" 
                                class="recipe-image">

                            <div class="recipe-overlay">
                                <span class="recipe-time">
                                    <span class="material-symbols-outlined">schedule</span>
                                    @formatTime(($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0))
                                </span>

                                @auth
                                    @php
                                        $isFavorited = $recipe->favorites()
                                                            ->where('user_id', auth()->id())
                                                            ->exists();
                                    @endphp

                                    <button class="recipe-favorite-btn {{ $isFavorited ? 'favorited' : '' }}" 
                                            data-recipe-id="{{ $recipe->id }}">
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

                            <div class="btn">
                                <a href="{{ route('recipes.show', $recipe->id) }}">View Recipe</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="no-recipes">This user has not shared any recipes yet.</p>
                @endforelse
            </div>
        </section>
        </main>
    </body>
</html>



        
