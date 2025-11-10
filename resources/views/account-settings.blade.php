<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/account-settings.css', 'resources/js/account-settings.js'])

    <title>RecyShare</title>
</head>

<body>
    <header>
        <nav class="navbar">
            <button class="burger-toggle" aria-label="Open menu">
                <span class="material-icons">menu</span>
            </button>
            <div class="left">
                <div class="logo">
                    <img src="{{ asset('assets/logos/recyshare-logo-no-text.png') }}" alt="RecyShare Logo">
                    <h3>RecyShare</h3>
                </div>
            </div>
            <div class="right">
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
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
                <div class="account">
                    <img class="icon" src="{{ asset('assets/icons/account_circle_48dp_000000_FILL0_wght300_GRAD200_opsz48.png') }}"
                        alt="Account">
                </div>
            </div>
        </nav>
    </header>
    <main>
     <div class="settings-wrap container">
        <aside class="left-sidebar">
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item active"><a href="#profile">Profile</a></li>
                    <li class="nav-item"><a href="#account">Account Settings</a></li>
                    <li class="nav-item"><a href="#shared">Your Shared Recipes</a></li>
                    <li class="nav-item"><a href="#favorites">Favorites</a></li>
                    <li class="divider"></li>
                    <li class="nav-item logout"><a href="#logout">Log out</a></li>
                </ul>
            </nav>
        </aside>

        <section class="content-area">
            <h2 class="section-title">Profile Information</h2>

            <div id="profile" class="panel tab-panel">
                <form class="profile-form">
                    <div class="form-row">
                        <label class="form-label">Name</label>
                        <input class="form-input" type="text" name="name" value="{{ old('name', optional(auth()->user())->name ?? ' ') }}">
                    </div>

                    <div class="form-row">
                        <label class="form-label">Username</label>
                        <input class="form-input" type="text" name="username" value="{{ old('username', optional(auth()->user())->username ?? ' ') }}">
                    </div>

                    <div class="form-row">
                        <label class="form-label">Bio</label>
                        <textarea class="form-textarea" name="bio" rows="4">{{ old('bio', optional(auth()->user())->bio ?? ' ') }}</textarea>
                    </div>

                    <div class="form-row">
                        <button type="button" class="save-btn">Save</button>
                    </div>
                </form>
            </div>

            <div id="account" class="panel tab-panel hidden">
                <form class="account-profile-form">
                    <div class="form-row">
                        <label class="form-label">Full Name</label>
                        <input class="form-input" type="text" name="full_name" value="{{ old('full_name', optional(auth()->user())->name ?? ' ') }}">
                    </div>
                    <div class="form-row">
                        <label class="form-label">Email Address</label>
                        <input class="form-input" type="email" name="email" value="{{ old('email', optional(auth()->user())->email ?? ' ') }}">
                    </div>
                    <div class="form-row small">
                        <button type="button" class="save-btn">Save</button>
                    </div>
                </form>

                <h2 class="section-title">Change Password</h2>
                <form class="password-form">
                    <div class="form-row">
                        <label class="form-label">Current Password</label>
                        <input class="form-input" type="password" name="current_password">
                    </div>
                    <div class="form-row">
                        <label class="form-label">New Password</label>
                        <input class="form-input" type="password" name="new_password">
                    </div>
                    <div class="form-row">
                        <label class="form-label">Repeat Your New Password</label>
                        <input class="form-input" type="password" name="new_password_confirmation">
                    </div>
                    <div class="form-row">
                        <button type="button" class="save-btn">Save</button>
                    </div>
                </form>
            </div>
        
            <div id="shared" class="panel tab-panel hidden">
                <div class="cards-grid">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="card-wrapper">
                            <div class="card"></div>
                            <div class="card-actions">
                                <button class="remove-btn" type="button">Remove</button>
                                <button class="edit-btn" type="button" title="Edit">Edit</button>
                            </div>
                        </div>  
                    @endfor
                </div>
            </div>

            <div id="favorites" class="panel tab-panel hidden">
                <div class="cards-grid">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="card-wrapper">
                            <div class="card"></div>
                            <div class="card-actions">
                                <button class="remove-btn" type="button">Remove</button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </section>
    </div>
    </main>

    
</body>

</html>