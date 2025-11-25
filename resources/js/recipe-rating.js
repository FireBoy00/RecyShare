document.addEventListener('DOMContentLoaded', function () {
    const widget = document.getElementById('rating-widget');
    if (!widget) return;
    const recipeId = widget.dataset.recipeId;
    let userRating = parseInt(widget.dataset.userRating) || 0;
    const buttons = widget.querySelectorAll('.star-btn');

    // Helper: set active class on the first n buttons (1..n)
    function setActive(n) {
        buttons.forEach((b, i) => {
            if (i < n) b.classList.add('active');
            else b.classList.remove('active');
        });
    }

    // Helper: set hover class on the first n buttons (1..n)
    function setHover(n) {
        buttons.forEach((b, i) => {
            if (i < n) b.classList.add('hover');
            else b.classList.remove('hover');
        });
    }

    // Helper: clear all hover classes
    function clearHover() {
        buttons.forEach(b => b.classList.remove('hover'));
    }

    // Initialize active state from existing user rating
    setActive(userRating);

    buttons.forEach(btn => {
        const val = parseInt(btn.dataset.value);
        // preview on hover
        btn.addEventListener('mouseover', () => setHover(val));
        btn.addEventListener('focus', () => setHover(val));
        // restore after hover/focus out
        btn.addEventListener('mouseout', () => clearHover());
        btn.addEventListener('blur', () => clearHover());

        btn.addEventListener('click', async () => {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';
            try {
                const res = await fetch(`/recipes/${recipeId}/rating`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ rating: val })
                });
                if (res.ok) {
                    const json = await res.json();
                    console.log('Rating saved, server response:', json);
                    userRating = json.rating;
                    setActive(userRating);
                    const avg = widget.querySelector('.average-rating');
                    if (avg && json.average !== undefined) {
                        avg.textContent = `Rating: ${json.average} / 5 (${json.count})`;
                    }
                } else {
                    const txt = await res.text();
                    console.error('Rating failed', res.status, txt);
                    // show small UI hint
                    alert('Rating failed: ' + res.status + '\n' + txt);
                }
            } catch (err) {
                console.error('Rating error', err);
            }
        });
    });
});
