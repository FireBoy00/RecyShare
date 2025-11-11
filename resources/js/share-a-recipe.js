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
    addIngredientBtn.addEventListener("click", () => {
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
    });

    /**
     * Add cooking step to the list
     * Uses textContent to prevent XSS attacks from malicious step descriptions
     */
    addStepBtn.addEventListener("click", () => {
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
    });

    /**
     * Handle form submission
     * Currently logs data to console - will be connected to backend API later
     * Note: textContent is used to extract values, which is XSS-safe
     */
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        // Collect all form data safely
        const data = {
            recipeName: document.getElementById("recipeName").value.trim(),
            category: document.getElementById("category").value.trim(),
            prepTime: document.getElementById("prepTime").value,
            cookTime: document.getElementById("cookTime").value,
            servings: document.getElementById("servings").value,
            // Extract text from list items (remove button text will be included, needs backend cleanup)
            ingredients: Array.from(ingredientsList.querySelectorAll("li")).map(li => {
                // Get only the text from the span, not the button
                return li.querySelector('span').textContent.trim();
            }),
            steps: Array.from(stepsList.querySelectorAll("li")).map(li => {
                // Get only the text from the span, not the button
                return li.querySelector('span').textContent.trim();
            })
        };

        // TODO: Send data to backend API endpoint
        console.log("Recipe data:", data);
        alert("Recipe logged to console!");
    });
});
