{{-- 
    Recipe Card Component
    Reusable recipe card displaying image, title, description, time, and categories
    Props: $recipe - Recipe model instance, $isPreview - Whether this is a preview card
    @author RecyShare Team
--}}

@props(['recipe', 'isPreview' => false])

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
            <div class="recipe-badges">
                <span class="recipe-time">
                    <span class="material-symbols-outlined">schedule</span>
                    @formatTime(($recipe->prep_time ?? 0) + ($recipe->cook_time ?? 0))
                </span>
                <span class="recipe-servings" style="display: {{ ($isPreview || $recipe->servings) ? 'flex' : 'none' }};">
                    <span class="material-symbols-outlined">restaurant</span>
                    {{ $recipe->servings ?? 0 }}
                </span>
            </div>
            @auth
                @php
                    $isFavorited = $recipe->favorites()->where('user_id', auth()->id())->exists();
                    $isOwner = $recipe->user_id === auth()->id();
                @endphp
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button class="recipe-favorite-btn {{ $isFavorited ? 'favorited' : '' }}" data-recipe-id="{{ $recipe->id }}">
                        <span class="material-symbols-outlined">
                            {{ $isFavorited ? 'favorite' : 'favorite_border' }}
                        </span>
                    </button>
                    @if($isOwner)
                        <a href="{{ route('recipes.create') }}?edit={{ $recipe->id }}" class="action-btn edit-btn" title="Edit">
                            <span class="material-symbols-outlined">edit</span>
                            <span class="btn-label">Edit</span>
                        </a>
                        <button class="action-btn delete-recipe-btn" data-recipe-id="{{ $recipe->id }}" type="button" title="Delete">
                            <span class="material-symbols-outlined">delete</span>
                            <span class="btn-label">Delete</span>
                        </button>
                    @endif
                </div>
            @endauth
        </div>
    </div>
    <div class="recipe-content">
        <h3 class="recipe-title">{{ $recipe->title }}</h3>
        <div class="recipe-content-bottom">
            <p class="recipe-description" title="{{ $recipe->description ?? 'A delicious recipe waiting for you to try!' }}">
                {{ $recipe->description ?? 'A delicious recipe waiting for you to try!' }}
            </p>
            <div class="recipe-categories">
                @if($recipe->categories && is_array($recipe->categories) && count($recipe->categories) > 0)
                    @foreach($recipe->categories as $category)
                        <span class="category-tag-small">{{ $category }}</span>
                    @endforeach
                @endif
            </div>

            <a href="{{ $isPreview ? '#' : route('recipes.show', $recipe->id) }}" class="btn" {{ $isPreview ? 'onclick="return false;"' : '' }}>View Recipe</a>
        </div>
    </div>
</div>
