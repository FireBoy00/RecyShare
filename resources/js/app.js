/**
 * Main Application JavaScript
 * Entry point for the RecyShare application.
 * Imports Bootstrap configuration which sets up Axios for API calls.
 * @author RecyShare Team
 */
import './bootstrap';

/**
 * Global search functionality for the navbar
 * On recipes page: search as you type
 * On other pages: redirect to recipes page with search query on Enter
 */
document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.getElementById('searchBar');
    
    if (searchBar) {
        const currentPage = searchBar.dataset.currentPage;
        
        // If not on recipes page, handle Enter key to redirect
        if (currentPage !== 'recipes') {
            searchBar.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = searchBar.value.trim();
                    if (query) {
                        window.location.href = `/recipes?search=${encodeURIComponent(query)}`;
                    } else {
                        window.location.href = '/recipes';
                    }
                }
            });
            
            // Also handle search icon click
            const searchIcon = searchBar.previousElementSibling;
            if (searchIcon && searchIcon.classList.contains('icon')) {
                searchIcon.style.cursor = 'pointer';
                searchIcon.addEventListener('click', () => {
                    const query = searchBar.value.trim();
                    if (query) {
                        window.location.href = `/recipes?search=${encodeURIComponent(query)}`;
                    } else {
                        window.location.href = '/recipes';
                    }
                });
            }
        }
        // On recipes page, the search functionality is handled by recipes.js
    }
});
