<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/home.css'])
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
                        <img class="icon" src="{{ asset('assets/icons/search_48dp_000000_FILL0_wght300_GRAD200_opsz48.png') }}"
                            alt="Search">
                        <input type="search" id="searchBar" placeholder="Search...">
                    </div>
                    <x-account-nav />
                </div>
            </nav>
            <div class="hero">
                <h1>Your Kitchen, Your Story.<br>
                    Share It With the World Today!</h1>
                <a href="{{ route('recipes.create') }}" class="btn" id="shareBtn">Share a Recipe</a>
            </div>
        </header>
    </body>
</html>