/**
 * Recipes Page JavaScript
 * Handles search functionality and favorite toggling for recipes.
 * @author RecyShare Team
 */

/**
 * Search and filter recipes by title and description
 * @param {string} args - Search query string
 * Filters recipes in real-time and updates the header with results count
 */
function search(args = "") {
    const filter = args.toLowerCase();
    const recipesContainer = document.querySelector('.recipes-container');
    const recipesList = document.getElementById('recipesList');
    const recipes = recipesList.querySelectorAll('.recipe-card');
    
    let recipesFound = 0;
    // Filter each recipe card based on search query
    recipes.forEach(recipe => {
        const title = recipe.querySelector('.recipe-title');
        const description = recipe.querySelector('.recipe-description');
        // Combine title and description for comprehensive search
        const txtValue = `${title?.textContent ?? ''} ${description?.textContent ?? ''}`;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
            recipe.style.display = "";
            recipesFound++;
        } else {
            recipe.style.display = "none";
        }
    })

    // Update header based on search results
    if (recipesFound === 0) {
        recipesContainer.querySelector('h1').textContent = `No recipes found for "${args}"`;
        return;
    }
    if (args.trim() !== "") {
        recipesContainer.querySelector('h1').textContent = `Found ${recipesFound} recipes for "${args}"`;
        return;
    }
    recipesContainer.querySelector('h1').textContent = `We have ${recipes.length} recipes`;
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
    if (searchBar) {
        searchBar.addEventListener('input', function() {
            search(this.value);
        });
    }
    
    // Setup favorite buttons
    setupFavoriteButtons();

    // Listen for favorites toggled from other pages (settings, detail) and update UI
    window.addEventListener('favoriteToggled', (e) => {
        const { recipeId, isFavorited } = e.detail || {};
        console.log('Favorite toggled event received:', { recipeId, isFavorited });
        if (!recipeId) return;
        const btn = document.querySelector(`.recipe-favorite-btn[data-recipe-id="${recipeId}"]`);
        if (!btn) {
            console.log('Favorite button not found for recipe:', recipeId);
            return;
        }
        const icon = btn.querySelector('.material-symbols-outlined');
        if (isFavorited) {
            icon.textContent = 'favorite';
            btn.classList.add('favorited');
            console.log('Recipe favorited:', recipeId);
        } else {
            icon.textContent = 'favorite_border';
            btn.classList.remove('favorited');
            console.log('Recipe unfavorited:', recipeId);
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
