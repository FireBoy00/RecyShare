{{-- 
    Recipe Card Component
    Reusable recipe card displaying image, title, description, time, and categories
    Props: $recipe - Recipe model instance
    @author RecyShare Team
--}}

@props(['recipe'])

<div class="recipe-card" data-recipe-id="{{ $recipe->id }}">
    <div class="recipe-image-wrapper">
        @php
            $imgPath = null;
            if ($recipe->image) {
                if (str_starts_with($recipe->image, 'assets/') || str_starts_with($recipe->image, 'http')) {
                    $imgPath = asset($recipe->image);
                } else {
                    $imgPath = asset('storage/' . $recipe->image);
                }
            } else {
                $imgPath = asset('assets/food/no-image.jpg');
            }
        @endphp
        <img src="{{ $imgPath }}" alt="{{ $recipe->title }}" class="recipe-image">
        <div class="recipe-overlay">
            <span class="recipe-time">
                <span class="material-symbols-outlined">schedule</span>
                @formatTime(($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0))
            </span>
            @auth
                @php
                    $isFavorited = $recipe->favorites()->where('user_id', auth()->id())->exists();
                @endphp
                <button class="recipe-favorite-btn {{ $isFavorited ? 'favorited' : '' }}" data-recipe-id="{{ $recipe->id }}">
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

        <a href="{{ route('recipes.show', $recipe->id) }}" class="btn">View Recipe</a>
        
    </div>
</div>
