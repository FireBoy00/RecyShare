function genRecipes(count = 5) {
    const recipeTemp = document.getElementById('recipeTemplate');
    const recipesList = document.getElementById('recipesList');
    for (let i = 0; i < count; i++) {
        var newRecipe = recipeTemp.content.cloneNode(true);
        const name = genRecipeName();
        const description = genRecipeDescription();
        newRecipe.querySelector('#recipeImage img').src = `https://placehold.co/250x160/025b3f/2ec68a/?text=${name}\\n- ${i + 1} -`;
        newRecipe.querySelector('#recipeTitle').textContent = name;
        newRecipe.querySelector('#recipeDescription').textContent = description;
        newRecipe.querySelector('#recipeLink').href = `./recipe-detail.html/recipe-${i + 1}`;
        recipesList.appendChild(newRecipe);
    }
}

function search(args = "") {
    const filter = args.toLowerCase();
    const recipesContainer = document.querySelector('.recipes-container');
    const recipesList = document.getElementById('recipesList');
    const recipes = recipesList.querySelectorAll('.recipe-card');
    
    var recipesFound = 0;
    recipes.forEach(recipe => {
        const title = recipe.querySelector('#recipeTitle');
        const description = recipe.querySelector('#recipeDescription');
        const txtValue = `${title?.textContent ?? ''} ${description?.textContent ?? ''}`;
        if (txtValue.toLowerCase().indexOf(filter) > -1) { // We used indexOf instead of includes for broader compatibility
            recipe.style.display = "";
            recipesFound++;
        } else {
            recipe.style.display = "none";
        }
    })

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
    document.querySelectorAll('#removeBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.parentElement.remove();
            search(document.getElementById('searchBar').value); // Update the count after removal
        });
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