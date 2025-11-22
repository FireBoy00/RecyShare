<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/profile.css'])
        @vite(['resources/css/recipes.css'])
        @vite(['resources/js/profile.js'])
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
                    <x-recipe-card :recipe="$recipe" />
                @empty
                    <p class="no-recipes">This user has not shared any recipes yet.</p>
                @endforelse
            </div>
        </section>
        </main>
    </body>
</html>



        
