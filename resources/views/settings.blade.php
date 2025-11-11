<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/settings.css', 'resources/js/settings.js'])
        <title>Settings | RecyShare</title>
    </head>

    <body>
        <header>
            <x-navbar currentPage="" />
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
                            <li class="nav-item logout">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Log out</button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </aside>

                <section class="content-area">
                    <h2 class="section-title">Profile Information</h2>

                    @if(session('status'))
                        <div class="form-message-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="form-message-error">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div id="profile" class="panel tab-panel">
                        <form class="profile-form" method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            <input type="hidden" name="active_tab" value="profile">
                            <div class="form-row">
                                <label class="form-label">Username</label>
                                <input class="form-input" type="text" name="username" value="{{ old('username', Auth::user()->username ?? '') }}" readonly>
                                <small style="color: #666; font-size: 12px;">Username cannot be changed</small>
                            </div>

                            <div class="form-row">
                                <label class="form-label">Display Name</label>
                                <input class="form-input" type="text" name="display_name" value="{{ old('display_name', Auth::user()->display_name ?? '') }}">
                                <small style="color: #666; font-size: 12px;">This is how your name will appear to others</small>
                            </div>

                            <div class="form-row">
                                <label class="form-label">Bio</label>
                                <textarea class="form-textarea" name="bio" rows="4">{{ old('bio', Auth::user()->bio ?? '') }}</textarea>
                            </div>

                            <div class="form-row">
                                <button type="submit" class="save-btn">Save Profile</button>
                            </div>
                        </form>
                    </div>

                    <div id="account" class="panel tab-panel hidden">
                        <form class="account-profile-form" method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            <input type="hidden" name="active_tab" value="account">
                            <div class="form-row">
                                <label class="form-label">Email Address</label>
                                <input class="form-input" type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                            </div>
                            <div class="form-row small">
                                <button type="submit" class="save-btn">Save Account Info</button>
                            </div>
                        </form>

                        <h2 class="section-title">Change Password</h2>
                        <form class="password-form" method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            <input type="hidden" name="active_tab" value="account">
                            <input type="hidden" name="password_change" value="1">
                            <div class="form-row">
                                <label class="form-label">Current Password</label>
                                <input class="form-input" type="password" name="current_password">
                            </div>
                            <div class="form-row">
                                <label class="form-label">New Password</label>
                                <input class="form-input" type="password" name="password">
                            </div>
                            <div class="form-row">
                                <label class="form-label">Repeat Your New Password</label>
                                <input class="form-input" type="password" name="password_confirmation">
                            </div>
                            <div class="form-row">
                                <button type="submit" class="save-btn">Change Password</button>
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