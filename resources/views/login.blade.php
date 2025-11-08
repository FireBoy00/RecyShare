<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | RecyShare</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  @vite([
    'resources/css/app.css',
    'resources/css/login.css',
    'resources/js/app.js'
  ])

  <script src="{{ asset('js/login.js') }}" defer></script>
</head>
<body class="login-page">
  <div class="login-overlay">
    <section class="login-card">
      <!-- Left: Dino section -->
      <div class="login-left">
        <div class="login-left-inner">
          <img
            src="{{ asset('assets/logos/dino-welcome.png') }}"
            alt="Cooking dino illustration"
            class="login-dino"
            loading="lazy"
          />
        </div>
      </div>

      <!-- Right: Form section -->
      <div class="login-right">
        <h1 class="login-title">Welcome Back!</h1>

        <p class="login-subtext">
          Don’t have an account?
          <a href="#">Create a new account now.</a><br />
          It’s FREE! Takes less than a minute.
        </p>


        <form method="POST" action="{{ url('/login') }}">
          @csrf
          <input
            type="text"
            name="email"
            placeholder="Email or Username"
            required
            class="login-input"
          />
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
            class="login-input"
          />
          <button type="submit" class="login-btn">Login Now</button>
        </form>

        <p class="login-forgot">
          Forgot <a href="#">Username</a> or <a href="#">Password</a>?
        </p>
      </div>
    </section>
  </div>
</body>
</html>
