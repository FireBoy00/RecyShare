<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        $ingredients = [
            '2 cups flour',
            '1 cup sugar',
            '3 eggs',
            '1/2 cup butter',
            '1 tsp vanilla extract',
            '1 cup milk',
            '2 tsp baking powder',
            '1/2 tsp salt'
        ];
        
        $instructions = [
            'Preheat oven to 350°F (175°C).',
            'Mix dry ingredients in a large bowl.',
            'In another bowl, beat eggs and add wet ingredients.',
            'Combine wet and dry ingredients until smooth.',
            'Pour into prepared pan.',
            'Bake for 30-35 minutes or until golden brown.',
            'Let cool before serving.'
        ];
        
        $allCategories = ['Breakfast', 'Lunch', 'Dinner', 'Dessert', 'Snack', 'Vegan', 'Vegetarian', 'Gluten-Free', 'Quick & Easy', 'Comfort Food'];
        
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->words(3, true) . ' Recipe',
            'description' => $this->faker->sentence(12),
            'image' => null,
            'prep_time' => $this->faker->numberBetween(10, 60),
            'cook_time' => $this->faker->numberBetween(15, 120),
            'servings' => $this->faker->numberBetween(2, 8),
            'ingredients' => $this->faker->randomElements($ingredients, $this->faker->numberBetween(4, 8)),
            'instructions' => $this->faker->randomElements($instructions, $this->faker->numberBetween(4, 7)),
            'categories' => $this->faker->randomElements($allCategories, $this->faker->numberBetween(2, 4)),
        ];
    }
}
