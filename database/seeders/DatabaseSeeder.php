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

        //Ola
        $olaFasola = User::factory()->create([
            'username' => 'MasterChef',
            'display_name' => 'Ola Fasola',
            'email' => 'ola@example.com',
            'profile_image' => 'assets/developers/olaFasola.jpg',
            'bio' => 'Obsessed with all the beans no matter if coffee or greens. My recipes will often include a beany twist in them 😉',
        ]);

        //Gabi
        $gabite = User::factory()->create([
            'username' => 'Gabite',
            'display_name' => 'Gabija Netavoreikalas',
            'email' => 'gabite@example.com',
            'profile_image' => 'assets/developers/Gabija.jpg',
            'bio' => 'Kitchen veteran. My mom taught me everything... then I perfected it. 😉 Go and check those recipes!',
        ]);

        //Jakub
        $skibiBake = User::factory()->create([
            'username' => 'SkibiBake',
            'display_name' => 'Jan Slota',
            'email' => 'skibi@example.com',
            'bio' => 'Bakin is my whole vibe 🍪✨ makin treats so good they got ppl delulu for seconds fr fr — it’s giving sugar rush supremacy 💅 ',
        ]);
        
        //Adrian
        $elly = User::factory()->create([
            'username' => 'The Culinary Catalyst',
            'display_name' => 'Eliza "Elly" Chen',
            'email' => 'elly@example.com',
            'bio' => 'I am a writer who cooks to de-stress. I believe great food does not need to be complicated. My mission is sharing "weeknight wonders" that maximize flavor with minimal time and effort. I focus on simple ingredients and efficient methods so you can spend less time cooking, and more time enjoying!',
        ]);

        //Dodo
        $remy = User::factory()->create([
            'username' => 'Remy',
            'display_name' => 'Auguste Gusteau',
            'email' => 'remy@example.com',
            'bio' => 'Just a small rat with big chef energy 🐭👨‍🍳 Cooking in places I technically shouldn’t be, but hey... flavor knows no species. My recipes? Bold, buttery, and a little bit rebellious. Bon appétit (my hat hides my secrets nomm)! 🍷🥖 ',
        ]);

        //Tomass
        $jamal = User::factory()->create([
            'username' => 'Midnight Meal Maker',
            'display_name' => 'Jamal Reed',
            'email' => 'jamal@example.com',
            'bio' => 'A 29-year-old nightlife photographer who cooks at odd hours. Posts creative comfort food fusions and crowd-pleasers ideal for late-night cravings. Uses the network as a social hub to swap ideas with other unconventional cooks.',
        ]);

        $userMap = [
            'elly' => $elly->id,
            'olaFasola' => $olaFasola->id,
            'gabite' => $gabite->id,
            'skibiBake' => $skibiBake->id,
            'remy' => $remy->id,
            'jamal' => $jamal->id,
        ];



        $recipes = json_decode(file_get_contents(database_path('recipes.json')), true);

        foreach ($recipes as $recipe) {
            if (isset($userMap[$recipe['user_id']])) {
                $recipe['user_id'] = $userMap[$recipe['user_id']];
            } else {
                throw new Exception("Unknown user_id in JSON: " . $recipe['user_id']);
            }


            Recipe::create($recipe);
        }
    }
}
