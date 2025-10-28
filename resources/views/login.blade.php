<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | RecyShare</title>

  <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />

  <script src="{{ asset('js/global.js') }}" defer></script>
  <script src="{{ asset('js/login.js') }}" defer></script>
</head>
<body>

  <header>
    <nav class="navbar">
      <div class="left">
        <div class="logo">
          <img src="{{ asset('assets/logos/recyshare-logo-no-text.png') }}" alt="RecyShare Logo" />
          <h3>RecyShare</h3>
        </div>
      </div>
      <div class="right">
        <ul class="nav-links">
          <li><a href="{{ url('/home') }}">Home</a></li>
          <li><a href="{{ url('/recipes') }}">Recipes</a></li>
          <li><a href="{{ url('/categories') }}">Categories</a></li>
          <li><a href="{{ url('/share-a-recipe') }}">Share</a></li>
          <li><a href="{{ url('/about') }}">About</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <main class="login-container">
    <div class="login-card">
      <h2>Welcome Back!</h2>
      <p>Log in to continue sharing your recipes :)</p>

      <form id="login-form" method="POST" action="/login">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required />

        <button type="submit">Login</button>
      </form>

      <div class="login-links">
        <p>Don’t have an account? <a href="{{ url('/signup') }}">Sign up</a></p>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 RecyShare. All rights reserved.</p>
  </footer>
</body>
</html>
