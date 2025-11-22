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
                'resources/js/constants.js',
                
                // Components
                'resources/css/recipe-card.css',
                'resources/js/recipe-card.js',

                // Authentication
                'resources/css/login.css',
                'resources/css/signup.css',

                // Home
                'resources/css/home.css',

                // About
                'resources/css/about.css',

                // Recipes listing
                'resources/css/recipes.css',
                'resources/js/recipes.js',

                // Recipe detail
                'resources/css/recipe-detail.css',
                'resources/js/recipe-detail.js',

                // Share a recipe
                'resources/css/share-a-recipe.css',
                'resources/js/share-a-recipe.js',

                // User profile
                'resources/css/profile.css',
                'resources/js/profile.js',

                // Settings
                'resources/css/settings.css',
                'resources/js/settings.js',
            ],
            refresh: true,
        }),
    ],
});
