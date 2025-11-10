<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @vite(['resources/css/share-a-recipe.css', 'resources/js/share-a-recipe.js'])
  <title>Share a Recipe – RecyShare</title>
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="left">
        <div class="logo">
          <img src="/assets/logos/recyshare-logo-no-text.png" alt="RecyShare Logo">
          <h3>RecyShare</h3>
        </div>
      </div>
      <div class="right">
        <ul class="nav-links">
          <li><a href="/home">Home</a></li>
          <li><a href="/about">About</a></li>
          <li><a href="/recipes">Recipes</a></li>
          <li class="dropdown">
            <span class="dropbtn">Categories</span>
            <div class="dropdown-content">
              <a href="#">Breakfast</a>
              <a href="#">Lunch</a>
              <a href="#">Dinner</a>
              <a href="#">Dessert</a>
              <a href="#">Vegan</a>
              <a href="#">Gluten-Free</a>
            </div>
          </li>
        </ul>
        <div class="search-bar">
          <img class="icon" src="/assets/icons/search_48dp_000000_FILL0_wght300_GRAD200_opsz48.png" alt="Search">
          <input type="search" id="searchBar" placeholder="Search...">
        </div>
        <div class="account">
          <img class="icon" src="/assets/icons/account_circle_48dp_000000_FILL0_wght300_GRAD200_opsz48.png" alt="Account">
        </div>
      </div>
    </nav>
  </header>

  <main class="container">
    <section class="form-section">
      <h1 class="page-title">Share a Recipe</h1>

      <form id="recipeForm" class="recipe-form">
        <div class="form-top">
          <div class="image-upload">
            <label for="imageInput" class="image-label">
              <div id="imagePreview" class="image-preview">Tap or click to add photo</div>
              <input type="file" id="imageInput" accept="image/*" hidden />
            </label>
          </div>

          <div class="text-inputs">
            <input type="text" id="recipeName" placeholder="Recipe Name" required />
            <input type="text" id="category" placeholder="Category" />
            
            
<div class="time-inputs">
  <input type="number" placeholder="Prep Time (min)">
  <input type="number" placeholder="Cook Time (min)">
  <input type="number" placeholder="Servings">
</div>
</div>
          
        </div>

        <div class="form-bottom">
          <div class="ingredients-section">
            <h3>Ingredients</h3>
            <ul id="ingredientsList"></ul>
            <div class="input-add">
              <input type="text" id="ingredientInput" placeholder="Add ingredient..." />
              <button type="button" id="addIngredientBtn">+</button>
            </div>
          </div>

          <div class="steps-section">
            <h3>Steps</h3>
            <ol id="stepsList"></ol>
            <div class="input-add">
              <input type="text" id="stepInput" placeholder="Add step..." />
              <button type="button" id="addStepBtn">+</button>
            </div>
          </div>
        </div>
  <div class="description-section">
  <h3>Description</h3>
  <textarea placeholder="Describe your recipe..."></textarea>
</div>

        <button type="submit" class="submit-btn">CREATE A RECIPE</button>
      </form>
    </section>
  </main>
</body>
</html>

