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
    const addIngredientBtn = document.getElementById("addIngredientBtn");
    const addStepBtn = document.getElementById("addStepBtn");
    const ingredientsList = document.getElementById("ingredientsList");
    const stepsList = document.getElementById("stepsList");
    const ingredientInput = document.getElementById("ingredientInput");
    const stepInput = document.getElementById("stepInput");
    const form = document.getElementById("recipeForm");

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
            };
            reader.readAsDataURL(file);
        }
    });

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
            console.log('Image file appended:', imageInput.files[0].name);
        }

        // Extract ingredients from list items
        const ingredients = Array.from(ingredientsList.querySelectorAll("li")).map(li => {
            return li.querySelector('span').textContent.trim();
        });
        console.log('Ingredients:', ingredients);
        ingredients.forEach((ing, idx) => {
            formData.append(`ingredients[${idx}]`, ing);
        });

        // Extract instructions from list items
        const instructions = Array.from(stepsList.querySelectorAll("li")).map(li => {
            return li.querySelector('span').textContent.trim();
        });
        console.log('Instructions:', instructions);
        instructions.forEach((step, idx) => {
            formData.append(`instructions[${idx}]`, step);
        });

        // Extract categories (from comma-separated input)
        const categoryInput = document.getElementById("category").value.trim();
        const categories = categoryInput ? categoryInput.split(',').map(c => c.trim()) : [];
        console.log('Categories:', categories);
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
            console.log('Response:', data);

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
