<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/signup.css'])
        <title>Register | RecyShare</title>
    </head>

    <body class="signup-page">
        <div class="signup-overlay">
            <section class="signup-card">
                <!-- Left: Dino -->
                <div class="signup-left">
                    <div class="signup-left-inner">
                        <img src="{{ asset('assets/logos/dino-welcome.png') }}" alt="Cooking dino illustration"
                            class="signup-dino" loading="lazy" />
                    </div>
                </div>

                <!-- Right: Form -->
                <div class="signup-right">
                    <h1 class="signup-title">Register to Get Started</h1>

                    <form method="POST" action="{{ route('signup.post') }}">
                        @csrf
                        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required class="signup-input" />
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required class="signup-input" />
                        <input type="password" name="password" placeholder="Password" required class="signup-input" />
                        <input type="password" name="password_confirmation" placeholder="Repeat Password" required class="signup-input" />

                        <label class="signup-check">
                            <input type="checkbox" required />
                            I agree to the privacy policy.
                        </label>

                        <button type="submit" class="signup-btn">Register Now</button>
                        
                        @if(session('success'))
                            <div class="form-message-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="form-message-error">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                    </form>

                    <p class="signup-footer">
                        Already have an account? <a href="{{ route('login') }}">Log In Here.</a>
                    </p>
                </div>
            </section>
        </div>
    </body>
</html>
