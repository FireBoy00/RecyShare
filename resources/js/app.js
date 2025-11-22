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

    /**
     * Handle category scrolling with mouse wheel
     * Also manage scroll shadow indicator
     */
    const handleCategoryScroll = () => {
        const categoryContainers = document.querySelectorAll('.recipe-categories');
        
        categoryContainers.forEach(container => {
            // Check if content is scrollable
            const checkScrollable = () => {
                if (container.scrollWidth > container.clientWidth) {
                    container.classList.add('has-scroll');
                } else {
                    container.classList.remove('has-scroll');
                }
            };

            checkScrollable();
            window.addEventListener('resize', checkScrollable);

            // Enable horizontal scroll with mouse wheel
            container.addEventListener('wheel', (e) => {
                if (e.deltaY !== 0) {
                    e.preventDefault();
                    container.scrollLeft += e.deltaY;
                }
            }, { passive: false });
        });
    };

    handleCategoryScroll();

    // Re-run when content changes (for dynamically loaded content)
    const observer = new MutationObserver(() => {
        handleCategoryScroll();
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    /**
     * Fix favorites link auto-scroll issue
     * Prevent default anchor behavior for hash links in dropdown
     */
    const accountDropdown = document.querySelector('.account-dropdown');
    if (accountDropdown) {
        const hashLinks = accountDropdown.querySelectorAll('a[href*="#"]');
        hashLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                const hash = href.includes('#') ? href.split('#')[1] : null;
                
                if (hash && !href.startsWith('#')) {
                    // Link with path and hash (e.g., /settings#favorites)
                    e.preventDefault();
                    const path = href.split('#')[0];
                    window.location.href = href;
                    
                    // After navigation, scroll to top
                    if (window.location.pathname === path.replace(window.location.origin, '')) {
                        setTimeout(() => {
                            window.scrollTo(0, 0);
                        }, 100);
                    }
                }
            });
        });
    }
});
