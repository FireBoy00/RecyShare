/**
 * Settings Page JavaScript
 * Handles sidebar navigation, tab switching, and card actions
 * for the settings page.
 * @author RecyShare Team
 */
import '../css/settings.css';

// DOM ready: initialize overlay, sidebar, tab navigation and card actions
document.addEventListener('DOMContentLoaded', () => {
    // Ensure a single overlay element exists for the off-canvas sidebar
    function getOrCreateOverlay() {
        let overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);
        }
        return overlay;
    }

    const burger = document.querySelector('.burger-toggle');
    const sidebar = document.querySelector('.left-sidebar');
    const overlay = getOrCreateOverlay();

    function openSidebar() {
        if (sidebar) sidebar.classList.add('open');
        overlay.classList.add('visible');
        document.body.classList.add('no-scroll');
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('open');
        overlay.classList.remove('visible');
        document.body.classList.remove('no-scroll');
    }

    if (burger && sidebar) {
        burger.addEventListener('click', () => {
            if (sidebar.classList.contains('open')) closeSidebar();
            else openSidebar();
        });
    }

    overlay.addEventListener('click', closeSidebar);

    // Close sidebar when a sidebar nav item is clicked (mobile)
    document.addEventListener('click', (e) => {
        const target = e.target;
        if (target && target.closest && target.closest('.sidebar-nav .nav-item')) {
            if (window.innerWidth <= 900) closeSidebar();
        }
    });

    // Hash-based tab navigation
    // Prevent automatic history scroll restoration so we can control scrolling
    try {
        if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
    } catch (e) {}
    // Start at top to avoid the browser jumping to a hash target before JS runs
    window.scrollTo(0, 0);

    const navLinks = Array.from(document.querySelectorAll('.sidebar-nav a[href^="#"]'));
    const panels = document.querySelectorAll('.tab-panel');
    const sectionTitle = document.querySelector('.section-title');

    function activate(targetId) {
        // mark active nav item
        navLinks.forEach(link => {
            const li = link.closest('.nav-item');
            if (!li) return;
            const hrefId = (link.getAttribute('href') || '').replace('#', '');
            li.classList.toggle('active', hrefId === targetId);
        });

        // show/hide panels
        panels.forEach(p => p.classList.toggle('hidden', p.id !== targetId));

        // Adjust main heading for the panel
        if (sectionTitle) {
            if (targetId === 'profile' || targetId === 'account') sectionTitle.textContent = 'Profile Information';
            else if (targetId === 'shared') sectionTitle.textContent = 'Your Shared Recipes';
            else if (targetId === 'favorites') sectionTitle.textContent = 'Favorites';
            else sectionTitle.textContent = '';
        }

        // Ensure the document is at top after switching panels
        window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
    }

    function handleHash() {
        const hash = (location.hash || '#profile');
        const id = hash.replace('#', '') || 'profile';
        activate(id);
    }

    // React to back/forward navigation (hash changes)
    window.addEventListener('hashchange', handleHash);

    // Intercept sidebar link clicks: update URL, activate panel, and close mobile sidebar
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const id = (link.getAttribute('href') || '').replace('#', '') || 'profile';
            // close mobile sidebar if open
            if (window.innerWidth <= 900) {
                closeSidebar();
            }
            // update the URL without letting the browser auto-scroll
            try {
                history.pushState(null, '', '#' + id);
            } catch (err) {
                // fall back to setting location.hash if pushState isn't allowed
                location.hash = '#' + id;
            }
            // activate selected panel
            activate(id);
        });
    });

    // Initialize current panel from the URL hash
    handleHash();

    // Auto-hide ALL messages (success and error) after 5 seconds
    function autoHideMessages() {
        document.querySelectorAll('.form-message-success, .form-message-error').forEach(msg => {
            setTimeout(() => {
                msg.style.transition = 'opacity 0.5s ease';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }, 5000);
        });
    }
    
    // Run on page load
    autoHideMessages();

    // Remove ALL messages immediately when switching tabs
    window.addEventListener('hashchange', () => {
        document.querySelectorAll('.form-message-success, .form-message-error').forEach(msg => {
            msg.remove();
        });
    });

    // Update hidden active_tab inputs when tab changes
    const activeTabInputs = document.querySelectorAll('input[name="active_tab"]');
    window.addEventListener('hashchange', () => {
        const currentHash = (location.hash || '#profile').replace('#', '');
        activeTabInputs.forEach(input => {
            const form = input.closest('form');
            const panel = form ? form.closest('.tab-panel') : null;
            if (panel && panel.id === currentHash) {
                input.value = currentHash;
            }
        });
    });

    // Restore active tab from session/request (for post-submission)
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    if (activeTab) {
        history.replaceState(null, '', window.location.pathname + '#' + activeTab);
        activate(activeTab);
        // Re-run auto-hide after tab restoration
        autoHideMessages();
    }

    // Client-side handler for Remove buttons (calls backend toggle and dispatches cross-page event)
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest && e.target.closest('.remove-btn');
        if (!btn) return;
        const wrapper = btn.closest('.card-wrapper');
        if (!wrapper) return;

        const recipeId = btn.dataset.recipeId;
        if (!recipeId) {
            // fallback: just remove UI
            if (confirm('Remove this recipe from the list?')) wrapper.remove();
            return;
        }

        if (!confirm('Remove this recipe from your favorites?')) return;

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
                const errorText = await resp.text();
                console.error('Response error:', resp.status, errorText);
                throw new Error(`HTTP error! status: ${resp.status}`);
            }

            const data = await resp.json();
            
            if (data.success) {
                // remove from DOM
                wrapper.remove();

                // Check if there are any favorites left
                const cardsGrid = document.querySelector('#favorites .cards-grid');
                const remainingCards = cardsGrid ? cardsGrid.querySelectorAll('.card-wrapper').length : 0;
                
                // If no more favorites, show empty state
                if (remainingCards === 0) {
                    if (cardsGrid) {
                        cardsGrid.remove();
                    }
                    const favoritesPanel = document.querySelector('#favorites');
                    if (favoritesPanel) {
                        const emptyState = document.createElement('div');
                        emptyState.className = 'empty-state';
                        emptyState.innerHTML = `
                            <p>You haven't favorited any recipes yet.</p>
                            <a href="${document.querySelector('a[href*="recipes.index"]')?.href || '/recipes'}" class="btn-primary">Browse Recipes</a>
                        `;
                        favoritesPanel.appendChild(emptyState);
                    }
                }

                // dispatch an event so other pages (recipes, detail) can react
                window.dispatchEvent(new CustomEvent('favoriteToggled', { detail: { recipeId: parseInt(recipeId), isFavorited: data.isFavorited } }));
            } else {
                alert('Could not remove favorite: ' + (data.message || 'Unknown error'));
                console.error('Remove favorite failed:', data);
            }
        } catch (err) {
            console.error('Error removing favorite from settings:', err);
            alert('Error while removing favorite: ' + err.message);
        } finally {
            btn.disabled = false;
        }
    });

    // Handler for delete recipe buttons in shared recipes
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest && e.target.closest('.delete-recipe-btn');
        if (!btn) return;
        const wrapper = btn.closest('.card-wrapper');
        if (!wrapper) return;

        const recipeId = btn.dataset.recipeId;
        if (!recipeId) return;

        if (!confirm('Are you sure you want to permanently delete this recipe?')) return;

        btn.disabled = true;
        try {
            const resp = await fetch(`/recipes/${recipeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!resp.ok) throw new Error('Network response not ok');
            const data = await resp.json();
            if (data.success) {
                wrapper.remove();
                // dispatch event so recipes page can update
                window.dispatchEvent(new CustomEvent('recipeDeleted', { detail: { recipeId: parseInt(recipeId) } }));
            } else {
                alert('Could not delete recipe: ' + (data.message || 'Unknown'));
            }
        } catch (err) {
            console.error('Error deleting recipe:', err);
            alert('Error deleting recipe');
        } finally {
            btn.disabled = false;
        }
    });
});
