<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/login.css'])
        <title>Login | RecyShare</title>
    </head>

    <body class="login-page">
        <div class="login-overlay">
            <section class="login-card">
                <!-- Left: Dino section -->
                <div class="login-left">
                    <div class="login-left-inner">
                        <img src="{{ asset('assets/logos/dino-welcome.png') }}" alt="Cooking dino illustration" class="login-dino" loading="lazy" />
                    </div>
                </div>

                <!-- Right: Form section -->
                <div class="login-right">
                    <h1 class="login-title">Welcome Back!</h1>

                    <p class="login-subtext">
                        Don’t have an account?
                        <a href="{{ route('signup') }}">Create a new account now.</a><br />
                        It’s FREE! Takes less than a minute.
                    </p>


                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required class="login-input" />
                        <input type="password" name="password" placeholder="Password" required class="login-input" />
                        <button type="submit" class="login-btn">Login Now</button>
                        
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
                </div>
            </section>
        </div>
    </body>
</html>
