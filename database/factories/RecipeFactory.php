<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'ingredients' => [
                $this->faker->word(),
                $this->faker->word(),
                $this->faker->word(),
            ],
            'instructions' => [
                $this->faker->sentence(),
                $this->faker->sentence(),
            ],
        ];
    }
}
