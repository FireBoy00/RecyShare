function genRecipes(count = 5) {
    const recipeTemp = document.getElementById('recipeTemplate');
    const recipesList = document.getElementById('recipesList');
    const recipeDetailsRoute = window.recipeDetailsRoute || '/recipe-details';

    recipesList.innerHTML = '';

    for (let i = 0; i < count; i++) {
        const newRecipe = recipeTemp.content.cloneNode(true);
        const name = genRecipeName();
        const description = genRecipeDescription();
        const recipeLinkElement = newRecipe.querySelector('#recipeLink');

        if (i === 0) {
            // Card 1: Monte Cristo Sandwich
            newRecipe.querySelector('#recipeImage img').src =
                '../assets/food/Monte-Cristo-Sandwich-1664x834-1.jpg';
            newRecipe.querySelector('#recipeTitle').textContent = "Monte Cristo Sandwich";
            newRecipe.querySelector('#recipeDescription').textContent =
                "A delightful sweet and savory breakfast or brunch treat.";
        } else {
            // Card 2 onwards: dynamic placeholder images
            newRecipe.querySelector('#recipeImage img').src =
                `https://placehold.co/600x400/025b3f/2ec68a/?text=${name}\n- ${i + 1} -`;
            newRecipe.querySelector('#recipeTitle').textContent = name;
            newRecipe.querySelector('#recipeDescription').textContent = description;
        }

        recipeLinkElement.href = recipeDetailsRoute + "?recipe=" + (i + 1);
        recipesList.appendChild(newRecipe);
    }
}

// Search: hide/show cards based on input value
function search(args = "") {
    const filter = args.toLowerCase();
    const recipesList = document.getElementById('recipesList');
    const recipes = recipesList.querySelectorAll('.recipe-card');

    recipes.forEach(recipe => {
        const title = recipe.querySelector('#recipeTitle');
        const description = recipe.querySelector('#recipeDescription');
        const txtValue = `${title?.textContent ?? ''} ${description?.textContent ?? ''}`;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
            recipe.style.display = "";
        } else {
            recipe.style.display = "none";
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    genRecipes(10);

    const searchInput = document.getElementById('searchBar');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            search(this.value);
        });
    }

    const filtersToggle = document.getElementById('filtersToggle');
    const filtersPanel = document.getElementById('recipesFilters');
    if (filtersToggle && filtersPanel) {
        filtersToggle.addEventListener('click', function () {
            const isHidden = filtersPanel.hasAttribute('hidden');
            if (isHidden) {
                filtersPanel.removeAttribute('hidden');
            } else {
                filtersPanel.setAttribute('hidden', '');
            }
        });
    }

    const viewToggleBtn = document.getElementById('viewToggle');
    const recipesList = document.getElementById('recipesList');
    if (viewToggleBtn && recipesList) {
        viewToggleBtn.addEventListener('click', function () {
            recipesList.classList.toggle('list-view');
        });
    }

    // Initial filter (no text)
    search();
});

function genRecipeName() {
    const adjectives = ["Delicious", "Tasty", "Yummy", "Scrumptious", "Savory", "Spicy", "Sweet", "Tangy", "Zesty", "Hearty"];
    const mainIngredients = ["Chicken", "Beef", "Pork", "Tofu", "Vegetable", "Seafood", "Pasta", "Rice", "Salad", "Soup"];
    const dishTypes = ["Stir-Fry", "Curry", "Stew", "Grill", "Bake", "Roast", "Salad", "Sandwich", "Wrap", "Pizza"];
    const adjective = adjectives[Math.floor(Math.random() * adjectives.length)];
    const mainIngredient = mainIngredients[Math.floor(Math.random() * mainIngredients.length)];
    const dishType = dishTypes[Math.floor(Math.random() * dishTypes.length)];
    return `${adjective} ${mainIngredient} ${dishType}`;
}

function genRecipeDescription() {
    const descriptions = [
        "A delightful dish that's perfect for any occasion.",
        "A flavorful recipe that will tantalize your taste buds.",
        "A quick and easy meal that's both healthy and delicious.",
        "A classic recipe with a modern twist.",
        "A hearty meal that's sure to satisfy your hunger.",
        "A light and refreshing dish that's perfect for summer.",
        "A rich and creamy recipe that's perfect for comfort food.",
        "A spicy and bold dish that's full of flavor.",
        "A sweet and tangy recipe that's sure to please.",
        "A savory meal that's packed with nutrients."
    ];
    return descriptions[Math.floor(Math.random() * descriptions.length)];
}
