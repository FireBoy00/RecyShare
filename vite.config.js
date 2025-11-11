import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Per-page assets
                'resources/css/app.css',
                'resources/js/app.js',

                // Home page
                'resources/css/home.css',
                'resources/js/recipes.js',

                // About page
                'resources/css/about.css',

                // Login page
                'resources/css/login.css',

                // Signup page
                'resources/css/signup.css',

                // Recipe detail page
                'resources/css/recipe-detail.css',
                'resources/js/recipe-detail.js',

                // Share a recipe page
                'resources/css/share-a-recipe.css',
                'resources/js/share-a-recipe.js',

                // Recipes listing page
                'resources/css/recipes.css',

                // Bootstrap (global, if needed)
                'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
    ],
});
