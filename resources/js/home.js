/**
 * Home Page JavaScript
 * Handles user carousel navigation
 * @author RecyShare Team
 */

document.addEventListener('DOMContentLoaded', function () {
    const usersContainer = document.querySelector('.users-container');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    if (!usersContainer || !prevBtn || !nextBtn) return;

    const scrollAmount = 300;

    prevBtn.addEventListener('click', () => {
        usersContainer.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });

    nextBtn.addEventListener('click', () => {
        usersContainer.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });

    // Hide/show buttons based on scroll position
    function updateButtonVisibility() {
        const { scrollLeft, scrollWidth, clientWidth } = usersContainer;
        
        prevBtn.style.opacity = scrollLeft <= 0 ? '0.5' : '1';
        prevBtn.style.cursor = scrollLeft <= 0 ? 'not-allowed' : 'pointer';
        
        nextBtn.style.opacity = scrollLeft + clientWidth >= scrollWidth - 1 ? '0.5' : '1';
        nextBtn.style.cursor = scrollLeft + clientWidth >= scrollWidth - 1 ? 'not-allowed' : 'pointer';
    }

    usersContainer.addEventListener('scroll', updateButtonVisibility);
    updateButtonVisibility();
});
