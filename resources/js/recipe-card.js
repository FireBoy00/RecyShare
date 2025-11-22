/**
 * Recipe Card Module
 * Shared functionality for recipe cards across the application.
 * Handles favorite toggling, recipe deletion, and UI updates.
 * @author RecyShare Team
 */

/**
 * Toggle favorite status for a recipe
 * @param {string|number} recipeId - The recipe ID
 * @returns {Promise<{success: boolean, isFavorited: boolean}>}
 */
export async function toggleFavorite(recipeId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) {
        throw new Error('CSRF token not found');
    }

    const response = await fetch(`/recipes/${recipeId}/toggle-favorite`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    
    if (data.success) {
        // Dispatch event so other pages can sync
        window.dispatchEvent(new CustomEvent('favoriteToggled', {
            detail: { recipeId: parseInt(recipeId), isFavorited: data.isFavorited }
        }));
    }

    return data;
}

/**
 * Delete a recipe
 * @param {string|number} recipeId - The recipe ID
 * @returns {Promise<{success: boolean, message: string}>}
 */
export async function deleteRecipe(recipeId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) {
        throw new Error('CSRF token not found');
    }

    const response = await fetch(`/recipes/${recipeId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    
    if (data.success) {
        // Dispatch event so other pages can sync
        window.dispatchEvent(new CustomEvent('recipeDeleted', {
            detail: { recipeId: parseInt(recipeId) }
        }));
    }

    return data;
}

/**
 * Update favorite button UI
 * @param {HTMLElement} button - The favorite button element
 * @param {boolean} isFavorited - Whether the recipe is favorited
 */
export function updateFavoriteButtonUI(button, isFavorited) {
    const icon = button.querySelector('.material-symbols-outlined');
    if (!icon) return;

    if (isFavorited) {
        icon.textContent = 'favorite';
        button.classList.add('favorited');
    } else {
        icon.textContent = 'favorite_border';
        button.classList.remove('favorited');
    }
}

/**
 * Setup favorite button click handlers
 * @param {HTMLElement|Document} container - Container element to search within (defaults to document)
 * @param {Object} options - Configuration options
 * @param {Function} options.onSuccess - Callback after successful toggle
 * @param {Function} options.onError - Callback on error
 */
export function setupFavoriteButtons(container = document, options = {}) {
    const { onSuccess, onError } = options;

    container.addEventListener('click', async (e) => {
        const btn = e.target.closest('.recipe-favorite-btn');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const recipeId = btn.dataset.recipeId;
        if (!recipeId) return;

        btn.disabled = true;

        try {
            const data = await toggleFavorite(recipeId);

            if (data.success) {
                updateFavoriteButtonUI(btn, data.isFavorited);
                
                if (onSuccess) {
                    onSuccess(recipeId, data.isFavorited, btn);
                }
            }
        } catch (error) {
            console.error('Error toggling favorite:', error);
            if (onError) {
                onError(error, recipeId, btn);
            }
        } finally {
            btn.disabled = false;
        }
    });
}

/**
 * Setup delete button click handlers
 * @param {HTMLElement|Document} container - Container element to search within (defaults to document)
 * @param {Object} options - Configuration options
 * @param {Function} options.onSuccess - Callback after successful deletion
 * @param {Function} options.onError - Callback on error
 * @param {string} options.confirmMessage - Custom confirmation message
 */
export function setupDeleteButtons(container = document, options = {}) {
    const {
        onSuccess,
        onError,
        confirmMessage = 'Are you sure you want to permanently delete this recipe?'
    } = options;

    container.addEventListener('click', async (e) => {
        const btn = e.target.closest('.delete-recipe-btn');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const recipeId = btn.dataset.recipeId;
        if (!recipeId) return;

        if (!confirm(confirmMessage)) return;

        btn.disabled = true;

        try {
            const data = await deleteRecipe(recipeId);

            if (data.success) {
                const card = btn.closest('.recipe-card');
                if (card) {
                    card.remove();
                }

                if (onSuccess) {
                    onSuccess(recipeId, btn);
                }
            } else {
                throw new Error(data.message || 'Unknown error');
            }
        } catch (error) {
            console.error('Error deleting recipe:', error);
            if (onError) {
                onError(error, recipeId, btn);
            } else {
                alert('Error deleting recipe: ' + error.message);
            }
        } finally {
            btn.disabled = false;
        }
    });
}

/**
 * Listen for favorite toggle events from other pages and update UI
 * @param {HTMLElement|Document} container - Container element to search within (defaults to document)
 */
export function listenForFavoriteChanges(container = document) {
    window.addEventListener('favoriteToggled', (event) => {
        const { recipeId, isFavorited } = event.detail || {};
        if (!recipeId) return;

        const btn = container.querySelector(`.recipe-favorite-btn[data-recipe-id="${recipeId}"]`);
        if (btn) {
            updateFavoriteButtonUI(btn, isFavorited);
        }
    });
}

/**
 * Listen for recipe deletion events from other pages and remove cards
 * @param {HTMLElement|Document} container - Container element to search within (defaults to document)
 * @param {Function} onDeleted - Callback when a card is removed
 */
export function listenForRecipeDeletion(container = document, onDeleted = null) {
    window.addEventListener('recipeDeleted', (event) => {
        const { recipeId } = event.detail || {};
        if (!recipeId) return;

        const card = container.querySelector(`.recipe-card[data-recipe-id="${recipeId}"]`);
        if (card) {
            card.remove();

            if (onDeleted) {
                onDeleted(recipeId, card);
            }
        }
    });
}

/**
 * Setup all recipe card interactions at once
 * @param {HTMLElement|Document} container - Container element to search within (defaults to document)
 * @param {Object} options - Configuration options
 */
export function setupRecipeCardActions(container = document, options = {}) {
    setupFavoriteButtons(container, options.favorite || {});
    setupDeleteButtons(container, options.delete || {});
    listenForFavoriteChanges(container);
    listenForRecipeDeletion(container, options.onDeleted);
}
