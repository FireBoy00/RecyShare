/**
 * Profile Page JavaScript
 * Handles favorite toggling and removal on the user profile page.
 * @author RecyShare Team
 */

document.addEventListener('DOMContentLoaded', () => {
    setupFavoriteButtons();
    listenForFavoriteChanges();
});

/**
 * Setup favorite toggle buttons on recipe cards
 */
function setupFavoriteButtons() {
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.recipe-favorite-btn');
        if (!btn) return;

        const recipeId = btn.dataset.recipeId;
        if (!recipeId) return;

        btn.disabled = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                throw new Error('CSRF token not found');
            }

            const resp = await fetch(`/recipes/${recipeId}/toggle-favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!resp.ok) {
                throw new Error(`HTTP error! status: ${resp.status}`);
            }

            const data = await resp.json();

            if (data.success) {
                const icon = btn.querySelector('.material-symbols-outlined');
                const card = btn.closest('.recipe-card');
                const removeBtn = card?.querySelector('.recipe-remove-favorite-btn');

                if (data.isFavorited) {
                    icon.textContent = 'favorite';
                    btn.classList.add('favorited');
                    if (removeBtn) removeBtn.style.display = 'flex';
                } else {
                    icon.textContent = 'favorite_border';
                    btn.classList.remove('favorited');
                    if (removeBtn) removeBtn.style.display = 'none';
                }

                window.dispatchEvent(new CustomEvent('favoriteToggled', {
                    detail: { recipeId: parseInt(recipeId), isFavorited: data.isFavorited }
                }));
            }
        } catch (err) {
            console.error('Error toggling favorite:', err);
        } finally {
            btn.disabled = false;
        }
    });
}

/**
 * Listen for favorite changes from other pages and update UI
 */
function listenForFavoriteChanges() {
    window.addEventListener('favoriteToggled', (event) => {
        const { recipeId, isFavorited } = event.detail || {};
        if (!recipeId) return;

        const card = document.querySelector(`.recipe-card[data-recipe-id="${recipeId}"]`);
        if (!card) return;

        const favoriteBtn = card.querySelector('.recipe-favorite-btn');
        const removeBtn = card.querySelector('.recipe-remove-favorite-btn');
        const icon = favoriteBtn?.querySelector('.material-symbols-outlined');

        if (isFavorited) {
            if (icon) icon.textContent = 'favorite';
            if (favoriteBtn) favoriteBtn.classList.add('favorited');
            if (removeBtn) removeBtn.style.display = 'flex';
        } else {
            if (icon) icon.textContent = 'favorite_border';
            if (favoriteBtn) favoriteBtn.classList.remove('favorited');
            if (removeBtn) removeBtn.style.display = 'none';
        }
    });
}

// Setup remove favorite buttons on page load
setupRemoveFavoriteButtons();
