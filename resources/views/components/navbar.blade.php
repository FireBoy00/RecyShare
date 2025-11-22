{{-- 
    Navbar Component
    Reusable navigation bar with logo, menu links, categories dropdown, search, and account menu.
    Props: $currentPage - indicates which page is active (home, about, recipes, etc.)
    @author RecyShare Team
--}}

@props(['currentPage' => ''])

<nav class="navbar">
    <div class="left">
        <div class="logo">
            <h3>RecyShare</h3>
            <img src="{{ asset('assets/logos/recyshare-logo-no-text.png') }}" alt="RecyShare Logo">
        </div>
    </div>
    <div class="right">
        <ul class="nav-links">
            <li @class(['active' => $currentPage === 'home'])>
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li @class(['active' => $currentPage === 'about'])>
                <a href="{{ route('about') }}">About</a>
            </li>
            <li @class(['active' => $currentPage === 'recipes'])>
                <a href="{{ route('recipes.index') }}">Recipes</a>
            </li>
            <li class="dropdown">
                <span class="dropbtn">Categories</span>
                <div class="dropdown-content">
                    <div class="dropdown-content-box">
                        <a href="#">Breakfast</a>
                        <a href="#">Lunch</a>
                        <a href="#">Dinner</a>
                        <a href="#">Dessert</a>
                        <a href="#">Vegan</a>
                        <a href="#">Gluten-Free</a>
                    </div>
                </div>
            </li>
        </ul>
        <div class="search-bar">
            <span class="material-symbols-outlined icon">search</span>
            <input type="search" id="searchBar" placeholder="Search..." data-current-page="{{ $currentPage }}">
        </div>
        <x-account-nav />
    </div>
</nav>
