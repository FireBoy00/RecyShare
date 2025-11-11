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
            <x-navbar currentPage="home" />
            <div class="hero">
                <h1>Your Kitchen, Your Story.<br>
                    Share It With the World Today!</h1>
                <a href="{{ route('recipes.create') }}" class="btn" id="shareBtn">Share a Recipe</a>
            </div>
        </header>
    </body>
</html>