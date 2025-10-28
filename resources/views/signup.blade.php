<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up | RecyShare</title>

  <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}" />

  <script src="{{ asset('js/global.js') }}" defer></script>
  <script src="{{ asset('js/signup.js') }}" defer></script>
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
        <div class="account">
          <a href="{{ url('/login') }}">
            <img class="icon" src="{{ asset('assets/icons/account_circle_48dp_000000_FILL0_wght300_GRAD200_opsz48.png') }}" alt="Account">
          </a>
        </div>
      </div>
    </nav>
  </header>

  <main class="signup-container">
    <div class="signup-card">
      <h2>Create an Account</h2>
      <p>Join RecyShare and start sharing your own recipes!</p>

      <form id="signup-form" method="POST" action="/signup">
        @csrf
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your full name" required />

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required />

        <label for="confirm">Confirm Password</label>
        <input type="password" id="confirm" name="confirm" placeholder="repeat password" required />

        <button type="submit">Sign Up</button>
      </form>

      <div class="signup-links">
        <p>Already have an account? <a href="{{ url('/login') }}">Log in</a></p>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 RecyShare. All rights reserved.</p>
  </footer>
</body>
</html>
