import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS files
                'resources/css/about.css',
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/login.css',
                'resources/css/recipe-detail.css',
                'resources/css/recipes.css',
                'resources/css/share-a-recipe.css',
                'resources/css/signup.css',
                // JS files
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/recipe-detail.js',
                'resources/js/recipes.js',
            ],
            refresh: true,
        }),
    ],
});
