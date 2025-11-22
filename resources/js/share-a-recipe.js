/**
 * Share-a-Recipe Page JavaScript
 * Handles image upload preview, dynamic ingredient/step list management,
 * and recipe form submission for creating new recipes.
 * @author RecyShare Team
 */

document.addEventListener("DOMContentLoaded", () => {
    // Get references to all form elements
    const imageInput = document.getElementById("imageInput");
    const imagePreview = document.getElementById("imagePreview");
    const imageUrl = document.getElementById("imageUrl");
    const removeImageInput = document.getElementById("removeImage");
    const addUrlBtn = document.getElementById("addUrlBtn");
    const removeImageBtn = document.getElementById("removeImageBtn");
    const addIngredientBtn = document.getElementById("addIngredientBtn");
    const addStepBtn = document.getElementById("addStepBtn");
    const ingredientsList = document.getElementById("ingredientsList");
    const stepsList = document.getElementById("stepsList");
    const ingredientInput = document.getElementById("ingredientInput");
    const stepInput = document.getElementById("stepInput");
    const form = document.getElementById("recipeForm");

    // Preview elements
    const previewImage = document.getElementById("previewImage");
    const previewTitle = document.getElementById("previewTitle");
    const previewDescription = document.getElementById("previewDescription");
    const previewTime = document.getElementById("previewTime");
    const previewCategories = document.getElementById("previewCategories");
    const previewServings = document.getElementById("previewServings");
    const previewServingsCount = document.getElementById("previewServingsCount");
    const recipeName = document.getElementById("recipeName");
    const categoryInput = document.getElementById("category");
    const descriptionInput = document.querySelector('textarea[name="description"]');
    const prepTimeInput = document.querySelector('input[name="prep_time"]');
    const cookTimeInput = document.querySelector('input[name="cook_time"]');
    const servingsInput = document.querySelector('input[name="servings"]');

    let currentImageSrc = null;

    /**
     * Update preview card in real-time
     */
    const updatePreview = () => {
        // Update title
        previewTitle.textContent = recipeName.value.trim() || 'Recipe Name';

        // Update description
        previewDescription.textContent = descriptionInput.value.trim() || 'A delicious recipe waiting for you to try!';

        // Update time
        const prepTime = parseInt(prepTimeInput.value) || 0;
        const cookTime = parseInt(cookTimeInput.value) || 0;
        const totalTime = prepTime + cookTime;
        const hours = Math.floor(totalTime / 60);
        const minutes = totalTime % 60;
        let timeStr = '';
        if (hours > 0) {
            timeStr += `${hours} hr `;
        }
        if (minutes > 0 || totalTime === 0) {
            timeStr += `${minutes} min`;
        }
        previewTime.textContent = timeStr.trim();

        // Update servings
        const servings = parseInt(servingsInput.value) || 0;
        if (servings > 0) {
            previewServingsCount.textContent = servings;
            previewServings.style.display = 'flex';
        } else {
            previewServings.style.display = 'none';
        }

        // Update categories
        const categoryValue = categoryInput.value.trim();
        const categories = categoryValue ? categoryValue.split(',').map(c => c.trim()).filter(c => c) : [];
        previewCategories.innerHTML = '';
        categories.forEach(cat => {
            const tag = document.createElement('span');
            tag.className = 'category-tag-small';
            tag.textContent = cat;
            previewCategories.appendChild(tag);
        });

        // Update image if there's a current source
        if (currentImageSrc) {
            previewImage.src = currentImageSrc;
        }
    };

    // Attach event listeners for real-time preview updates
    recipeName.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    prepTimeInput.addEventListener('input', updatePreview);
    cookTimeInput.addEventListener('input', updatePreview);
    servingsInput.addEventListener('input', updatePreview);
    categoryInput.addEventListener('input', updatePreview);

    // Initialize preview if in edit mode
    updatePreview();

    /**
     * Attach remove button listeners to list items
     */
    const attachRemoveListeners = (list) => {
        const removeButtons = list.querySelectorAll('button[aria-label*="Remove"]');
        removeButtons.forEach(btn => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                btn.closest('li').remove();
            });
        });
    };

    // Attach listeners to pre-populated items (in edit mode)
    attachRemoveListeners(ingredientsList);
    attachRemoveListeners(stepsList);

    /**
     * Handle image file selection and preview
     * Validates file type to prevent XSS attacks via malicious files
     */
    imageInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            // Validate file type to prevent XSS
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file');
                imageInput.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = (ev) => {
                // Clear previous content and create new image element safely
                imagePreview.textContent = '';
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.alt = 'Recipe Image';
                imagePreview.appendChild(img);
                currentImageSrc = ev.target.result;
                previewImage.src = currentImageSrc;
                removeImageBtn.style.display = 'inline-block';
                removeImageInput.value = '0';
                imageUrl.value = '';
            };
            reader.readAsDataURL(file);
        }
    });

    /**
     * Add image from URL
     */
    addUrlBtn.addEventListener('click', () => {
        const url = prompt('Enter image URL:');
        if (url && url.trim()) {
            const trimmedUrl = url.trim();
            // Basic URL validation
            if (!trimmedUrl.startsWith('http://') && !trimmedUrl.startsWith('https://')) {
                alert('Please enter a valid URL starting with http:// or https://');
                return;
            }
            // Update preview
            imagePreview.textContent = '';
            const img = document.createElement('img');
            img.src = trimmedUrl;
            img.alt = 'Recipe Image';
            img.onerror = () => {
                alert('Failed to load image from URL');
                imagePreview.textContent = 'Tap or click to add photo';
                currentImageSrc = null;
                previewImage.src = '{{ asset("assets/food/no-image.jpg") }}';
            };
            img.onload = () => {
                imagePreview.textContent = '';
                imagePreview.appendChild(img);
                currentImageSrc = trimmedUrl;
                previewImage.src = currentImageSrc;
                removeImageBtn.style.display = 'inline-block';
                imageUrl.value = trimmedUrl;
                imageInput.value = '';
                removeImageInput.value = '0';
            };
        }
    });

    /**
     * Remove current image
     */
    removeImageBtn.addEventListener('click', () => {
        imagePreview.textContent = 'Tap or click to add photo';
        imageInput.value = '';
        imageUrl.value = '';
        removeImageInput.value = '1';
        currentImageSrc = null;
        previewImage.src = '{{ asset("assets/food/no-image.jpg") }}';
        removeImageBtn.style.display = 'none';
    });

    // Show remove button if image exists in edit mode
    if (imagePreview.querySelector('img')) {
        removeImageBtn.style.display = 'inline-block';
        currentImageSrc = imagePreview.querySelector('img').src;
        previewImage.src = currentImageSrc;
    }

    /**
     * Add ingredient to the list
     * Uses textContent to prevent XSS attacks from malicious ingredient names
     */
    const handleAddIngredient = () => {
        const value = ingredientInput.value.trim();
        if (value) {
            // Create list item and add ingredient text safely
            const li = document.createElement("li");
            const textSpan = document.createElement("span");
            textSpan.textContent = value; // XSS-safe: uses textContent instead of innerHTML
            
            // Create remove button with Material Icon
            const removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.className = "material-symbols-outlined";
            removeBtn.textContent = "close";
            removeBtn.setAttribute("aria-label", "Remove ingredient");
            removeBtn.addEventListener("click", () => li.remove());
            
            li.appendChild(textSpan);
            li.appendChild(removeBtn);
            ingredientsList.appendChild(li);
            ingredientInput.value = "";
            ingredientInput.focus();
        }
    };

    // Add ingredient on button click
    addIngredientBtn.addEventListener("click", handleAddIngredient);

    // Add ingredient on Enter key press
    ingredientInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            handleAddIngredient();
        }
    });

    /**
     * Add cooking step to the list
     * Uses textContent to prevent XSS attacks from malicious step descriptions
     */
    const handleAddStep = () => {
        const value = stepInput.value.trim();
        if (value) {
            // Create list item and add step text safely
            const li = document.createElement("li");
            const textSpan = document.createElement("span");
            textSpan.textContent = value; // XSS-safe: uses textContent instead of innerHTML
            
            // Create remove button with Material Icon
            const removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.className = "material-symbols-outlined";
            removeBtn.textContent = "close";
            removeBtn.setAttribute("aria-label", "Remove step");
            removeBtn.addEventListener("click", () => li.remove());
            
            li.appendChild(textSpan);
            li.appendChild(removeBtn);
            stepsList.appendChild(li);
            stepInput.value = "";
            stepInput.focus();
        }
    };

    // Add step on button click
    addStepBtn.addEventListener("click", handleAddStep);

    // Add step on Enter key press
    stepInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            handleAddStep();
        }
    });

    /**
     * Handle form submission
     * Sends recipe data to backend API with image upload
     * Handles both create (POST) and edit (PUT) modes
     */
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Check if this is edit mode (recipe ID in URL params)
        const params = new URLSearchParams(window.location.search);
        const recipeId = params.get('edit');
        const isEditMode = !!recipeId;

        // Create FormData object for file upload
        const formData = new FormData();

        // Add text fields - convert to integers
        formData.append('title', document.getElementById("recipeName").value.trim());
        formData.append('description', document.querySelector('textarea[name="description"]').value.trim());
        formData.append('prep_time', parseInt(document.querySelector('input[name="prep_time"]').value) || 0);
        formData.append('cook_time', parseInt(document.querySelector('input[name="cook_time"]').value) || 0);
        formData.append('servings', parseInt(document.querySelector('input[name="servings"]').value) || 1);

        // Add image if selected
        if (imageInput.files.length > 0) {
            formData.append('image', imageInput.files[0]);
        } else if (imageUrl.value.trim()) {
            formData.append('image_url', imageUrl.value.trim());
        }

        // Add remove image flag
        formData.append('remove_image', removeImageInput.value);

        // Extract ingredients from list items
        const ingredients = Array.from(ingredientsList.querySelectorAll("li")).map(li => {
            return li.querySelector('span').textContent.trim();
        });
        ingredients.forEach((ing, idx) => {
            formData.append(`ingredients[${idx}]`, ing);
        });

        // Extract instructions from list items
        const instructions = Array.from(stepsList.querySelectorAll("li")).map(li => {
            return li.querySelector('span').textContent.trim();
        });
        instructions.forEach((step, idx) => {
            formData.append(`instructions[${idx}]`, step);
        });

        // Extract categories (from comma-separated input)
        const categoryInput = document.getElementById("category").value.trim();
        const categories = categoryInput ? categoryInput.split(',').map(c => c.trim()) : [];
        categories.forEach((cat, idx) => {
            formData.append(`categories[${idx}]`, cat);
        });

        // For PUT requests, need to add _method field for Laravel method spoofing
        if (isEditMode) {
            formData.append('_method', 'PUT');
        }

        // Disable submit button during request
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = isEditMode ? 'Updating...' : 'Creating...';

        try {
            const url = isEditMode ? `/recipes/${recipeId}` : '/recipes';
            const method = isEditMode ? 'POST' : 'POST'; // Laravel expects POST with _method field for PUT

            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                const message = isEditMode ? 'Recipe updated successfully!' : 'Recipe created successfully!';
                alert(message);
                // Redirect to recipe detail
                window.location.href = data.redirect_url || '/recipes';
            } else {
                alert('Error: ' + (data.message || 'Unknown error occurred'));
                console.error('Error details:', data);
                submitBtn.disabled = false;
                submitBtn.textContent = isEditMode ? 'UPDATE RECIPE' : 'CREATE A RECIPE';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.textContent = isEditMode ? 'UPDATE RECIPE' : 'CREATE A RECIPE';
        }
    });
});
