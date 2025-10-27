<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/share-a-recipe.css', 'resources/js/share-a-recipe.js'])
        <title>RecyShare</title>
    </head>
    <body>
        <header>
            <nav class="navbar">
                <div class="left">
                    <div class="logo">
                        <img src="{{ asset('assets/logos/recyshare-logo-no-text.png') }}" alt="RecyShare Logo">
                        <h3>RecyShare</h3>
                    </div>
                </div>
                <div class="right">
                    <ul class="nav-links">
                        <li class="active"><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('recipes.index') }}">Recipes</a></li>
                        <li><a href="{{ route('categories.index') }}">Categories</a></li>
                    </ul>
                    <div class="search-bar">
                        <img class="icon" src="{{ asset('assets/icons/search_48dp_000000_FILL0_wght300_GRAD200_opsz48.png') }}" alt="Search">
                        <input type="search" id="searchBar" placeholder="Search...">
                    </div>
                    <div class="account">
                        <img class="icon" src="{{ asset('assets/icons/account_circle_48dp_000000_FILL0_wght300_GRAD200_opsz48.png') }}" alt="Account">
                    </div>
                </div>
            </nav>

            
        </header>


<form id="multiForm" class="grid2x2">
    <div class="step">
      <label for="recipeName">Name of recipe</label><br />
      <input id="recipeName" type="text" name="recipe_name" required />
      <button type="button" data-focus="#description">Next</button>
    </div>

    <div class="step">
      <label for="description">Description</label><br />
      <input id="description" type="text" name="description" required />
      <button type="button" data-focus="#ingredients">Next</button>
    </div>

    <div class="step">
      <label for="ingredients">Ingredients</label><br />
      <input id="ingredients" type="text" name="ingredients" required />
      <button type="button" data-focus="#recipe">Next</button>
    </div>

    <div class="step">
      <label for="recipe">Process</label><br />
      <input id="recipe" type="text" name="recipe" required />
      <button type="button" data-focus="#recipeName">Back to top</button>
    </div>


    <div class="actions">
      <button type="reset" class="reset">Reset</button>
      <button type="submit" class="submit">Submit</button>
    </div>
  </form>

  <pre id="out"></pre>

  <script>

    document.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-focus]');
      if (!btn) return;
      const target = document.querySelector(btn.getAttribute('data-focus'));
      if (target) target.focus();
    });

    document.getElementById('multiForm').addEventListener('submit', (e) => {
      e.preventDefault();
      if (!e.target.reportValidity()) return; 
      const data = Object.fromEntries(new FormData(e.target).entries());
      document.getElementById('out').textContent = JSON.stringify(data, null, 2);
    });
  </script>
<script>
   
</script>
    </body>
</html>