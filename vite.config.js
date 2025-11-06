import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // TODO: Check if you can have to inputs for better visuals of what is css and what is js
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/about.css',
                'resources/css/recipe-detail.css',
                'resources/css/recipes.css',
                'resources/css/share-a-recipe.css',
                'resources/css/account-settings.css',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/about.js',
                'resources/js/recipe-detail.js',
                'resources/js/recipes.js',
                'resources/js/share-a-recipe.js',
                'resources/js/account-settings.js',
            ],
            refresh: true,
        }),
    ],
});
