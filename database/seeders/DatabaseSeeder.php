<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create first test user
        $johnDoe = User::factory()->create([
            'username' => 'johndoe',
            'display_name' => 'John Doe',
            'email' => 'john@example.com',
            'bio' => 'Passionate home cook and recipe creator.',
        ]);

        // Create second test user
        $janeCook = User::factory()->create([
            'username' => 'janecook',
            'display_name' => 'Jane Cook',
            'email' => 'jane@example.com',
            'bio' => 'Professional chef sharing my favorite recipes.',
        ]);



        // Create one special Monte Cristo Sandwich recipe for John Doe
        Recipe::create([
            'user_id' => $johnDoe->id,
            'title' => 'Monte Cristo Sandwich',
            'description' => 'A delightful sweet and savory breakfast or brunch treat that combines ham, turkey, and cheese in a perfectly golden fried sandwich.',
            'image' => 'assets/food/Monte-Cristo-Sandwich-1664x834-1.jpg',
            'prep_time' => 30,
            'cook_time' => 30,
            'servings' => 4,
            'ingredients' => [
                '8 slices bread (challah)',
                '4 tsp honey dijon mustard',
                '8 slices swiss cheese',
                '8 slices turkey',
                '8 slices ham',
                '3 eggs',
                '2 tbsp flour',
                '1 tbsp melted butter',
                'Salt & pepper',
                '2 tbsp milk',
                'Powdered sugar',
                'Raspberry preserves'
            ],
            'instructions' => [
                'Heat oven to 425°F.',
                'Butter a baking sheet.',
                'Spread mustard on bread slices.',
                'Layer cheese, ham, turkey, cheese.',
                'Whisk eggs, flour, butter, salt, pepper.',
                'Blend in milk.',
                'Dip sandwiches in egg mix.',
                'Bake 8-10 min each side until golden.',
                'Dust with powdered sugar & serve with preserves.'
            ],
            'categories' => ['French', 'Breakfast', 'Brunch', 'Comfort Food'],
        ]);
    }
}
