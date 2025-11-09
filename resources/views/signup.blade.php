<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register | RecyShare</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  @vite([
    'resources/css/app.css',
    'resources/css/signup.css',
    'resources/js/app.js'
  ])
</head>
<body class="signup-page">
  <div class="signup-overlay">
    <section class="signup-card">
      <!-- Left: Dino -->
      <div class="signup-left">
        <div class="signup-left-inner">
          <img
            src="{{ asset('assets/logos/dino-welcome.png') }}"
            alt="Cooking dino illustration"
            class="signup-dino"
            loading="lazy"
          />
        </div>
      </div>

      <!-- Right: Form -->
      <div class="signup-right">
        <h1 class="signup-title">Register to Get Started</h1>

        <form method="POST" action="#">
          <input type="text" name="username" placeholder="Username" required class="signup-input" />
          <input type="email" name="email" placeholder="Email" required class="signup-input" />
          <input type="password" name="password" placeholder="Password" required class="signup-input" />
          <input type="password" name="password_confirmation" placeholder="Repeat Password" required class="signup-input" />

          <label class="signup-check">
            <input type="checkbox" required />
            I agree to the privacy policy.
          </label>

          <button type="submit" class="signup-btn">Register Now</button>
        </form>

        <p class="signup-footer">
          Create an account or <a href="/login">Log In Here.</a>
        </p>
      </div>
    </section>
  </div>
</body>
</html>
