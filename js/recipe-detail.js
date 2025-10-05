document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const recipeId = params.get('recipe');
    if (!recipeId) {
        return;
    }
    loadRecipeDetails(recipeId);
});

function loadRecipeDetails(id) {
    console.log("Loading recipe details for ID:", id);
    // For demonstration, we'll use static content. In a real app, fetch data from a server or database.
    const recipeData = {
        title: "Monte Cristo Sandwich",
        image: "../assets/food/Monte-Cristo-Sandwich-1664x834-1.jpg",
        description: "A delightful sweet and savory breakfast or brunch treat.",
        ingredients: [
            "4 slices of bread",
            "2 slices of ham",
            "2 slices of turkey",
            "2 slices of Swiss cheese",
            "2 eggs",
            "1/4 cup milk",
            "Butter for frying",
            "Powdered sugar (optional)",
            "Raspberry jam (optional)"
        ],
        instructions: [
            "Layer the ham, turkey, and Swiss cheese between two slices of bread to make a sandwich.",
            "In a shallow bowl, whisk together the eggs and milk.",
            "Dip the sandwich into the egg mixture, ensuring both sides are coated.",
            "Heat a skillet over medium heat and melt some butter.",
            "Place the sandwich in the skillet and cook until golden brown on both sides and the cheese is melted, about 3-4 minutes per side.",
            "Remove from skillet and let it cool slightly. Optionally, dust with powdered sugar and serve with raspberry jam."
        ]
    };
    
    const container = document.getElementById('recipeDetailContainer');
    if (!container) return;
    container.querySelector('#recipeTitle').textContent = recipeData.title;
    container.querySelector('#recipeImage').src = recipeData.image;
    container.querySelector('#recipeImage').alt = recipeData.title;
    // container.querySelector('#recipeDescription').textContent = recipeData.description;
}