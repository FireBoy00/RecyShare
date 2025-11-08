document.addEventListener('DOMContentLoaded', function() {
    setupCommentForm();
    setupFavoriteButton();
    setupShareButton();
});

function loadRecipeDetails(id) {
    console.log("Loading recipe details for ID:", id);
}

function setupCommentForm() {
    const form = document.querySelector('.comment-form');
    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const commentInput = form.querySelector('input[name="comment"]');
        const comment = commentInput.value.trim();
        
        if (!comment) return;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ comment: comment })
            });

            const data = await response.json();
            
            if (data.success) {
                // Add the new comment to the thread
                const commentThread = document.querySelector('.comment-thread');
                const newComment = createCommentElement(data.comment);
                commentThread.insertBefore(newComment, commentThread.firstChild);
                
                // Clear the input
                commentInput.value = '';
            }
        } catch (error) {
            console.error('Error posting comment:', error);
        }
    });
}

function setupShareButton() {
    console.log('Setting up share button...');
    const shareForm = document.getElementById('shareForm');
    const shareBtn = document.getElementById('shareBtn');
    const sharePopup = document.getElementById('sharePopup');
    const shareLink = document.getElementById('shareLink');
    const copyBtn = document.getElementById('copyBtn');

    if (!shareBtn) console.error('Share button not found');
    if (!sharePopup) console.error('Share popup not found');
    if (!shareLink) console.error('Share link input not found');
    if (!copyBtn) console.error('Copy button not found');
    if (!shareForm) console.error('Share form not found');

    if (!shareBtn || !sharePopup || !shareLink || !copyBtn || !shareForm) return;

    let isPopupVisible = false;

    shareBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Share button clicked');
        isPopupVisible = !isPopupVisible;
        
        if (isPopupVisible) {
            sharePopup.style.display = 'block';
            // Force a reflow
            void sharePopup.offsetWidth;
            sharePopup.classList.add('show');
            shareBtn.classList.add('active');
        } else {
            sharePopup.classList.remove('show');
            shareBtn.classList.remove('active');
            // Delay hiding the popup until animation completes
            setTimeout(() => {
                if (!isPopupVisible) {
                    sharePopup.style.display = 'none';
                }
            }, 300);
        }
    });

    // Only close when clicking outside both the button and popup
    document.addEventListener('click', function(event) {
        if (!sharePopup.contains(event.target) && !shareBtn.contains(event.target)) {
            sharePopup.style.display = 'none';
            isPopupVisible = false;
        }
    });

    // Prevent popup from closing when clicking inside it
    sharePopup.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    copyBtn.addEventListener('click', async function() {
        try {
            await navigator.clipboard.writeText(shareLink.value);
            copyBtn.innerHTML = '<i class="fas fa-check"></i>';
        } catch (err) {
            console.error('Failed to copy text:', err);
            shareLink.select();
            document.execCommand('copy');
            copyBtn.innerHTML = '<i class="fas fa-check"></i>';
        }
    });
}

function createCommentElement(comment) {
    const div = document.createElement('div');
    div.className = 'comment-box';
    div.innerHTML = `
        <img src="/assets/developers/Gabija.jpg" class="user-avatar">
        <div class="comment-details">
            <p class="comment-author">${comment.author_name}</p>
            <p class="comment-text">${comment.content}</p>
        </div>
    `;
    return div;
}

function setupFavoriteButton() {
    const favoriteBtn = document.getElementById('favoriteBtn');
    const favoritePopup = document.getElementById('favoritePopup');
    if (!favoriteBtn || !favoritePopup) return;

    const recipeId = favoriteBtn.dataset.recipeId;
    const favoriteIcon = favoriteBtn.querySelector('.favorite-icon');

    favoriteBtn.addEventListener('click', async function() {
        // Disable button during request
        favoriteBtn.disabled = true;
        
        try {
            console.log('Sending favorite request for recipe:', recipeId);
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
            console.log('Favorite response:', data);
            
            if (data.success) {
                if (data.isFavorited) {
                    favoriteIcon.classList.remove('far');
                    favoriteIcon.classList.add('fas');
                    favoriteBtn.classList.add('favorited');
                    showPopup('Recipe saved to favorites!');
                } else {
                    favoriteIcon.classList.remove('fas');
                    favoriteIcon.classList.add('far');
                    favoriteBtn.classList.remove('favorited');
                    showPopup('Recipe removed from favorites');
                }
            }
        } catch (error) {
            console.error('Error toggling favorite:', error);
            showPopup('Error saving recipe');
        } finally {
            // Re-enable button
            favoriteBtn.disabled = false;
        }
    });

    function showPopup(message) {
        favoritePopup.textContent = message;
        favoritePopup.classList.add('show');
        setTimeout(() => {
            favoritePopup.classList.remove('show');
        }, 2000);
    }
}