/**
 * Recipes Page JavaScript
 * Handles dynamic recipe card generation, search functionality,
 * and recipe display logic.
 * @author RecyShare Team
 */

/**
 * Generate recipe cards dynamically
 * @param {number} count - Number of recipe cards to generate
 * Creates recipe cards with the first one being Monte Cristo Sandwich,
 * and the rest being randomly generated placeholders
 */
function genRecipes(count = 5) {
    const recipeTemp = document.getElementById('recipeTemplate');
    const recipesList = document.getElementById('recipesList');
    const recipeDetailsRoute = window.recipeDetailsRoute || '/recipe-details';
    recipesList.innerHTML = '';

    // Generate recipe cards
    for (let i = 0; i < count; i++) {
        var newRecipe = recipeTemp.content.cloneNode(true);
        const name = genRecipeName();
        const description = genRecipeDescription();
        const recipeLinkElement = newRecipe.querySelector('#recipeLink');
        
        // First card: Monte Cristo Sandwich (featured recipe)
        if (i === 0) {
            newRecipe.querySelector('#recipeImage img').src = '/assets/food/Monte-Cristo-Sandwich-1664x834-1.jpg';
            newRecipe.querySelector('#recipeTitle').textContent = "Monte Cristo Sandwich";
            newRecipe.querySelector('#recipeDescription').textContent = "A delightful sweet and savory breakfast or brunch treat.";
        } else {
            // Remaining cards: Generated placeholder recipes
            newRecipe.querySelector('#recipeImage img').src = `https://placehold.co/250x160/025b3f/2ec68a/?text=${name}\n- ${i + 1} -`;
            newRecipe.querySelector('#recipeTitle').textContent = name;
            newRecipe.querySelector('#recipeDescription').textContent = description;
        }
        // Set link to recipe details page
        recipeLinkElement.href = recipeDetailsRoute + "?recipe=" + (i + 1);
        recipesList.appendChild(newRecipe);
    }
}

/**
 * Search and filter recipes by title and description
 * @param {string} args - Search query string
 * Filters recipes in real-time and updates the header with results count
 */
function search(args = "") {
    const filter = args.toLowerCase();
    const recipesContainer = document.querySelector('.recipes-container');
    const recipesList = document.getElementById('recipesList');
    const recipes = recipesList.querySelectorAll('.recipe-card');
    
    var recipesFound = 0;
    // Filter each recipe card based on search query
    recipes.forEach(recipe => {
        const title = recipe.querySelector('#recipeTitle');
        const description = recipe.querySelector('#recipeDescription');
        // Combine title and description for comprehensive search
        const txtValue = `${title?.textContent ?? ''} ${description?.textContent ?? ''}`;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
            recipe.style.display = "";
            recipesFound++;
        } else {
            recipe.style.display = "none";
        }
    })

    // Update header based on search results
    if (recipesFound === 0) {
        recipesContainer.querySelector('h1').textContent = `No recipes found for "${args}"`;
        return;
    }
    if (args.trim() !== "") {
        recipesContainer.querySelector('h1').textContent = `Found ${recipesFound} recipes for "${args}"`;
        return;
    }
    recipesContainer.querySelector('h1').textContent = `We have ${recipes.length} recipes`;
}

document.addEventListener('DOMContentLoaded', function() {
    genRecipes(10); // Generate 10 sample recipes
    document.getElementById('searchBar').addEventListener('input', function() {
        search(this.value);
    });
    search(); // Initial search to set the count
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

/**
 * Generate random recipe description
 * @returns {string} Randomly selected description from predefined list
 */
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
