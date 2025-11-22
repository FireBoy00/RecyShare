import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Global assets
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                
                // Login
                'resources/css/login.css',

                // Signup
                'resources/css/signup.css',

                // Home
                'resources/css/home.css',
                'resources/js/recipes.js',

                // Settings
                'resources/css/settings.css',
                'resources/js/settings.js',

                // About
                'resources/css/about.css',

                // Recipe detail
                'resources/css/recipe-detail.css',
                'resources/js/recipe-detail.js',

                // Share a recipe
                'resources/css/share-a-recipe.css',
                'resources/js/share-a-recipe.js',

                // Recipes listing
                'resources/css/recipes.css',

                // User profile
                'resources/css/profile.css',
            ],
            refresh: true,
        }),
    ],
});
