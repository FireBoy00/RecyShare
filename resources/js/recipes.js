/**
 * Recipes Page JavaScript
 * Handles search functionality and favorite toggling for recipes.
 * @author RecyShare Team
 */

/**
 * Fetch recipes from server and render them
 * @param {string} query - Search query string
 */
async function fetchAndRenderRecipes(query = "") {
    const recipesContainer = document.querySelector('.recipes-container');
    const recipesList = document.getElementById('recipesList');
    
    if (!recipesContainer || !recipesList) return;
    
    try {
        // Show loading state
        recipesContainer.querySelector('h1').textContent = 'Searching...';
        
        // Fetch recipes from server
        const url = query 
            ? `/recipes?search=${encodeURIComponent(query)}`
            : '/recipes';
            
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch recipes');
        }
        
        const data = await response.json();
        const recipes = data.recipes;
        const count = data.count;
        
        // Clear current recipes
        recipesList.innerHTML = '';
        
        // Render new recipes
        if (recipes.length === 0) {
            recipesContainer.querySelector('h1').textContent = query 
                ? `No recipes found for "${query}"`
                : 'No recipes available';
            return;
        }
        
        // Update header
        if (query.trim() !== "") {
            recipesContainer.querySelector('h1').textContent = `Found ${count} recipes for "${query}"`;
        } else {
            recipesContainer.querySelector('h1').textContent = `We have ${count} recipes`;
        }
        
        // Render recipe cards
        recipes.forEach(recipe => {
            const card = createRecipeCard(recipe);
            recipesList.appendChild(card);
        });
        
        // Re-setup favorite buttons for new cards
        setupFavoriteButtons();
        
    } catch (error) {
        console.error('Error fetching recipes:', error);
        recipesContainer.querySelector('h1').textContent = 'Error loading recipes';
    }
}

/**
 * Create a recipe card element from recipe data
 * @param {Object} recipe - Recipe data object
 * @returns {HTMLElement} Recipe card element
 */
function createRecipeCard(recipe) {
    const card = document.createElement('div');
    card.className = 'recipe-card';
    card.dataset.recipeId = recipe.id;
    
    // Determine image path
    let imgPath = '/assets/food/no-image.jpg';
    if (recipe.image) {
        if (recipe.image.startsWith('assets/') || recipe.image.startsWith('http')) {
            imgPath = recipe.image.startsWith('http') ? recipe.image : `/${recipe.image}`;
        } else {
            imgPath = `/storage/${recipe.image}`;
        }
    }
    
    // Format time
    const totalTime = (recipe.prep_time || 0) + (recipe.cook_time || 0);
    let timeStr = '';
    if (totalTime >= 60) {
        const hours = Math.floor(totalTime / 60);
        const mins = totalTime % 60;
        timeStr = hours + 'h' + (mins > 0 ? ' ' + mins + 'm' : '');
    } else {
        timeStr = totalTime + 'm';
    }
    
    // Check if favorited (if user is logged in)
    const userLoggedIn = document.querySelector('meta[name="csrf-token"]') !== null;
    const isFavorited = false; // Will be determined by server response or existing state
    
    card.innerHTML = `
        <div class="recipe-image-wrapper">
            <img src="${imgPath}" alt="${recipe.title}" class="recipe-image">
            <div class="recipe-overlay">
                <div class="recipe-badges">
                    <span class="recipe-time">
                        <span class="material-symbols-outlined">schedule</span>
                        ${timeStr}
                    </span>
                    ${recipe.servings ? `
                        <span class="recipe-servings">
                            <span class="material-symbols-outlined">restaurant</span>
                            ${recipe.servings}
                        </span>
                    ` : ''}
                </div>
                ${userLoggedIn ? `
                    <button class="recipe-favorite-btn" data-recipe-id="${recipe.id}">
                        <span class="material-symbols-outlined">favorite_border</span>
                    </button>
                ` : ''}
            </div>
        </div>
        <div class="recipe-content">
            <h3 class="recipe-title">${recipe.title}</h3>
            <div class="recipe-content-bottom">
                <p class="recipe-description" title="${recipe.description || 'A delicious recipe waiting for you to try!'}">
                    ${recipe.description || 'A delicious recipe waiting for you to try!'}
                </p>
                <div class="recipe-categories">
                    ${recipe.categories && Array.isArray(recipe.categories) ? 
                        recipe.categories.map(cat => `<span class="category-tag-small">${cat}</span>`).join('') 
                        : ''}
                </div>
                <a href="/recipes/${recipe.id}" class="btn">View Recipe</a>
            </div>
        </div>
    `;
    
    return card;
}

/**
 * Setup favorite button functionality on recipe cards
 */
function setupFavoriteButtons() {
    const favoriteButtons = document.querySelectorAll('.recipe-favorite-btn');
    
    favoriteButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const recipeId = this.dataset.recipeId;
            const icon = this.querySelector('.material-symbols-outlined');
            
            // Disable button during request
            this.disabled = true;
            
            try {
                const response = await fetch(`/recipes/${recipeId}/toggle-favorite`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                
                if (data.success) {
                    if (data.isFavorited) {
                        icon.textContent = 'favorite';
                        this.classList.add('favorited');
                    } else {
                        icon.textContent = 'favorite_border';
                        this.classList.remove('favorited');
                    }
                    // Dispatch event so other pages (settings, detail) can sync
                    window.dispatchEvent(new CustomEvent('favoriteToggled', { detail: { recipeId: parseInt(recipeId), isFavorited: data.isFavorited } }));
                }
            } catch (error) {
                console.error('Error toggling favorite:', error);
            } finally {
                // Re-enable button
                this.disabled = false;
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const searchBar = document.getElementById('searchBar');
    let searchTimeout;
    
    // Get initial search query from URL
    const urlParams = new URLSearchParams(window.location.search);
    const initialQuery = urlParams.get('search') || '';
    
    if (searchBar && initialQuery) {
        searchBar.value = initialQuery;
    }
    
    if (searchBar) {
        // Debounced search as user types
        searchBar.addEventListener('input', function() {
            const query = this.value;
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Wait 500ms after user stops typing before searching
            searchTimeout = setTimeout(async () => {
                await fetchAndRenderRecipes(query);
                
                // Update URL without page reload
                const newUrl = query 
                    ? `${window.location.pathname}?search=${encodeURIComponent(query)}`
                    : window.location.pathname;
                window.history.replaceState({}, '', newUrl);
            }, 500);
        });
    }
    
    // Setup favorite buttons
    setupFavoriteButtons();

    // Listen for favorites toggled from other pages (settings, detail) and update UI
    window.addEventListener('favoriteToggled', (e) => {
        const { recipeId, isFavorited } = e.detail || {};
        if (!recipeId) return;
        const btn = document.querySelector(`.recipe-favorite-btn[data-recipe-id="${recipeId}"]`);
        if (!btn) return;
        const icon = btn.querySelector('.material-symbols-outlined');
        if (isFavorited) {
            icon.textContent = 'favorite';
            btn.classList.add('favorited');
        } else {
            icon.textContent = 'favorite_border';
            btn.classList.remove('favorited');
        }
    });

    // Listen for recipe deletions from other pages and remove card
    window.addEventListener('recipeDeleted', (e) => {
        const { recipeId } = e.detail || {};
        if (!recipeId) return;
        const card = document.querySelector(`.recipe-card[data-recipe-id="${recipeId}"]`);
        if (card) {
            card.remove();
        }
        // update header count if present
        const recipesContainer = document.querySelector('.recipes-container');
        if (recipesContainer) {
            const recipesList = document.getElementById('recipesList');
            const countEl = recipesContainer.querySelector('h1');
            if (countEl && recipesList) {
                const visible = Array.from(recipesList.querySelectorAll('.recipe-card')).filter(c => c.style.display !== 'none').length;
                countEl.textContent = `We have ${visible} recipes`;
            }
        }
    });
});
