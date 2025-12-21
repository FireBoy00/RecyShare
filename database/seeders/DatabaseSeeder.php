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





        //olafasola recipes
        /*
        Recipe::create([
            'user_id' => $olaFasola->id,
            'title' => 'Grilled Asian Chicken', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 30,
            'cook_time' => 15,
            'servings' => 4,
            'ingredients' => [
                '1/4 cup soy sauce',
                '2 tablespoons honey',
                '4 teaspoons sesame oil',
                '2 cloves gralic (crushed)',
                '3 slices fresh ginger root',
                '4 skinless, boneless chicken breast halves'
            ],
            'instructions' => [
                'Gather all ingredients',
                'Combine soy sauce, honey, sesame oil, garlic, and ginger in a small microwave-safe bowl; heat in the microwave on medium power for 1 minute, then stir. Heat again for 30 seconds, watching closely to prevent boiling. ',
                'Place chicken breasts in a shallow dish. Pour soy sauce mixture over top and set aside to marinate for 15 minutes ',
                'Preheat an outdoor grill for medium-high heat and lightly oil the grate. Meanwhile, remove chicken from marinade; transfer marinade into a small saucepan and bring to a boil. Reduce heat to low and simmer until thick, about 1 minute. Set aside for basting.',
                'Cook chicken on the preheated grill, basting frequently with reserved marinade, until golden brown on all sides and chicken is no longer pink in the center, about 6 to 8 minutes per side. An instant-read meat thermometer inserted into the thickest piece should read at least 160 degrees F (70 degrees C). '
            ],
            'categories' => ['Breakfast', 'Brunch', 'Quick & Easy'],
        ]);
        
        Recipe::create([
            'user_id' => $olaFasola->id,
            'title' => 'Tuscan Chicken Soup', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 10,
            'cook_time' => 20,
            'servings' => 2,
            'ingredients' => [
                '1 ½ teaspoons olive oil',
                '1/2 small onion, diced ',
                '2 garlic cloves, minced ',
                '1 tablespoon tomato paste',
                '2 (8.25 ounce) containers chicken bone broth',
                '3/4 teaspoon Tuscan seasoning',
                '1 skinless, boneless chicken breast, cut into 1-inch pieces',
                '1 handful roughly chopped spinach',
                '2 tablespoons sun dried tomatoes',
                '1/2 cup high protein pasta',
                '2 tablespoons finely grated Parmesan cheese',
                '1/4 cup heavy cream '
            ],
            'instructions' => [
                'Gather all ingredients',
                'Add oil to a saucepan over medium heat. Once oil is hot, add onion, and sauté until translucent, about 5 minutes.',
                'Add garlic; saute until fragrant; about 1 minute.',
                'Stir in tomato paste until well combined.',
                'Add chicken bone broth, Tuscan seasoning, chicken pieces, sun-dried tomatoes, and torn spinach; stir to combine',
                'Add pasta; simmer until pasta is tender with a bite, about 10 minutes.',
                'Sprinkle in Parmesan; stir to combine.',
                'Stir in heavy cream. Serve immediately.'
            ],

            'categories' => ['Soups', 'Healthy', 'Dinner'],
        ]);

        Recipe::create([
            'user_id' => $olaFasola->id,
            'title' => 'Old-Fashioned Potato Salad', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 45,
            'cook_time' => 15,
            'servings' => 8,
            'ingredients' => [
                '5 medium potatoes',
                '3 large eggs',
                '1 cup chopped celery',
                '½ cup chopped onion',
                '½ cup sweet pickle relish',
                '¼ cup mayonnaise',
                '1 tablespoon prepared mustard',
                '¼ teaspoon garlic salt',
                '¼ teaspoon celery salt',
                'ground black pepper to taste'
            ],
            'instructions' => [
                'Gather all ingredients',
                'Bring a large pot of salted water to a boil. Add potatoes and cook until tender but still firm, about 15 minutes. ',
                'Drain, cool, peel, and chop potatoes',
                'While potatoes cook, place eggs in a saucepan and cover with cold water. Bring water to a boil; cover, remove from heat, and let eggs stand in hot water for 10 to 12 minutes.',
                'Remove eggs from hot water; cool, peel, and chop into chunks',
                'Combine potatoes, eggs, celery, onion, relish, mayonnaise, mustard, garlic salt, celery salt, and pepper in a large bowl. Mix together until well combined. ',
                'Chill potato salad in the refrigerator before serving for best flavor results. Enjoy!'
            ],

            'categories' => ['Vegetarian', 'Healthy', 'Salads', 'Side Dish'],
        ]); 

        Recipe::create([
            'user_id' => $olaFasola->id,
            'title' => 'Cobb Salad', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 20,
            'cook_time' => 10,
            'servings' => 6,
            'ingredients' => [
                '6 slices bacon',
                '3 large eggs',
                '1 head iceberg lettuce, shredded',
                '3 cups chopped, cooked chicken meat',
                '2 ripe tomatoes, seeded and chopped',
                '¾ cup blue cheese, crumbled ',
                '3 green onions, chopped ',
                '1 avocado - peeled, pitted and diced',
                '1 (8 ounce) bottle Ranch-style salad dressing'
            ],
            'instructions' => [
                'Place eggs in a saucepan and cover completely with cold water; bring to a boil, then cover and remove from heat. Let eggs sit for 10 to 12 minutes, then cool, peel and chop',
                'While the eggs are cooking, place bacon in a large, deep skillet. Cook over medium-high heat until evenly brown, 7 to 10 minutes. Drain, crumble, and set aside',
                'Divide shredded lettuce among individual plates. Arrange rows of bacon, eggs, chicken, tomatoes, blue cheese, green onions, and avocado on top.',
                'Drizzle with dressing and enjoy!'
            ],

            'categories' => ['Quick & Easy', 'Healthy', 'Salads', 'Side Dish'],
        ]);
        
        Recipe::create([
            'user_id' => $olaFasola->id,
            'title' => 'Blueberry Lemonade Martini ', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 5,
            'cook_time' => 5,
            'servings' => 1,
            'ingredients' => [
                '2 fluid ounces lemon infused vodka ',
                '2 fluid ounces blueberry lemonade ',
                '1/2 fluid ounce agave syrup or simple syrup',
                '1 teaspoon freshly squeezed lime juice',
                '1 wedge plus 1 slice lemon or lime, divided, for garnish',
                'chili lime seasoning, such as Tajin® (optional)'

            ],
            'instructions' => [
                'Add vodka, blueberry lemonade, agave syrup, and lime juice to a cocktail shaker. ',
                'Fill the cocktail shaker with ice and shake until the outside is frosted, about 30 seconds.',
                'Sprinkle Tajin seasoning on a plate, rub the rim of your favorite glass with a lemon or lime wedge, and dip the glass in seasoning to coat the rim. Strain the cocktail into the glass'
            ],

            'categories' => ['Drink & Cocktail', 'Quick & Easy'],
        ]);
        
        //gabite recipes
        Recipe::create([
            'user_id' => $gabite->id,
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
        
        Recipe::create([
            'user_id' => $gabite->id,
            'title' => 'Traditional lasagna ', 
            'description' => null, //change 
            'image' => 'assets/food/lasagna.webp',  //change
            'prep_time' => 30,
            'cook_time' => 120,
            'servings' => 12,
            'ingredients' => [
                '1lb ground beef',
                '3⁄4lb bulk pork sausage  bulk pork sausage',
                '3(8 ounce) cans tomato sauce ',
                '2(6 ounce) cans tomato paste',
                '2garlic cloves, minced',
                '2teaspoons sugar',
                '1teaspoon italian seasoning',
                '1teaspoon salt',
                '1⁄2teaspoon pepper',
                '3eggs ',
                '3tablespoons minced fresh parsley',
                '3cups small curd cottage cheese ',
                '1(8 ounce) carton ricotta cheese ',
                '1⁄2cup grated parmesan cheese ',
                '9lasagna noodles, cooked and drained ',
                '6slices provolone cheese ',
                '3cups shredded mozzarella cheese, divided (12 oz.)'
            ],
            'instructions' => [
                'In a skillet, cook beef and sausage over medium heat until no longer pink; drain.',
                'Add the next seven ingredients. ',
                'Simmer, uncovered, for 1 hour, stirring occasionally.',
                'In a bowl, combine the eggs, parsley, cottage cheese, ricotta and parmesan.',
                'Spread 1 cup of meat sauce in an ungreased 13x9x2-inch baking dish.',
                'Layer with 3 noodles, provolone cheese, 2 cups of cottage cheese mixture, 1 cup of mozzarella, three noodles, 2 cups of meat sauce, remaining cottage cheese mixture and 1 cup of mozzarella.',
                'Top with remaining noodles, meat sauce and mozzarella (dish will be full).',
                'Cover and bake at 375°F for 50 minutes.',
                'Uncover; bake 20 minutes longer.',
                'Let stand 15 minutes before cutting.'
            ],

            'categories' => ['Dinner', 'Lunch'],
        ]);
        
        Recipe::create([
            'user_id' => $gabite->id,
            'title' => 'Vegan Bacon', 
            'description' => null, //change 
            'image' => 'assets/food/bacon.webp',  //change
            'prep_time' => null,
            'cook_time' => 25,
            'servings' => 4,
            'ingredients' => [
                '1lb firm tofu, cut into strips shaped like bacon',
                '2 tablespoons nutritional yeast',
                '2tablespoons soya sauce',
                '1teaspoon liquid smoke',
                '1tablespoon oil, something neutral, not olive oil'
            ],
            'instructions' => [
                'In a skillet, cook beef and sausage over medium heat until no longer pink; drain. ',
                'Add the next seven ingredients. ',
                'Simmer, uncovered, for 1 hour, stirring occasionally',
                'In a bowl, combine the eggs, parsley, cottage cheese, ricotta and parmesan. ',
                'Spread 1 cup of meat sauce in an ungreased 13x9x2-inch baking dish. ',
                'Layer with 3 noodles, provolone cheese, 2 cups of cottage cheese mixture, 1 cup of mozzarella, three noodles, 2 cups of meat sauce, remaining cottage cheese mixture and 1 cup of mozzarella. ',
                'Top with remaining noodles, meat sauce and mozzarella (dish will be full). ',
                'Cover and bake at 375°F for 50 minutes. ',
                'Uncover; bake 20 minutes longer. ',
                'Let stand 15 minutes before cutting.'
            ],

            'categories' => ['Vegetarian', 'Vegan'],
        ]);

        Recipe::create([
            'user_id' => $gabite->id,
            'title' => 'Simple Chicken and Sausage Paella', 
            'description' => null, //change 
            'image' => 'assets/food/paella.webp',  //change
            'prep_time' => null,
            'cook_time' => 45,
            'servings' => 6,
            'ingredients' => [
                '1⁄2lb hot Italian sausage, cut into 1/2 inch cubes',
                '1onion, chopped ',
                '1green bell pepper, chopped ',
                '2garlic cloves, minced',
                '1cup long-grain rice ',
                '14ounces canned tomatoes, chopped (homemade is better) ',
                '1cup chicken stock',
                '1⁄2teaspoon ground turmeric ',
                '1⁄4teaspoon cayenne pepper (we love spicy foods)',
                '1lb boneless skinless chicken breast, remove all visible fat and cut into 1 inch cubes ',
                'salt and pepper ',
                '1green onion, chopped diagonally'
            ],
            'instructions' => [
                'Using a 12 cup microwaveable dish, combine chopped sausages, onions, green pepper and garlic. Microwave uncovered at a High setting for approximately 4 to 6 minutes or until vegetables are soft. Stir halfway.',
                'Add long-grain rice, chopped tomatoes, chicken stock, turmeric and cayenne pepper. Stir and cover. Microwave at a High setting for approximately 8 to 10 minutes until boiling. Stir and cover. Microwave at a Medium setting for another 5 minutes',
                'Add chicken. Season with salt and pepper. Stir and cover. Microwave at a Medium setting for approximately 7 to 9 minutes or until the chicken is no longer pink inside and most of the liquid has been absorbed',
                'Let stand covered for another 5 minutes. ',
                'Serve with chopped green onions.'
            ],

            'categories' => ['Microwave', 'Lunch'],
        ]);

        Recipe::create([
            'user_id' => $gabite->id,
            'title' => 'Air Fryer Truffle Fries', 
            'description' => null, //change 
            'image' => 'assets/food/fries.webp',  //change
            'prep_time' => null,
            'cook_time' => 25,
            'servings' => 4,
            'ingredients' => [
                '1 1⁄4lbs yukon gold potatoes ',
                '1tablespoon olive oil ',
                '1⁄4teaspoon kosher salt',
                '3⁄4teaspoon truffle salt',
            ],
            'instructions' => [
                'Scrub potatoes and pat dry. Cut into evenly-sized fries and place in a bowl.',
                'Add olive oil and kosher salt and toss to coat. ',
                'Place fries in the air fryer basket and cook at 350-degrees F for 15 to 18 minutes, pausing half way through to shake the basket. Cook until golden and crispy.',
                'Remove fries from the basket and season immediately with truffle salt, serve hot. '
            ],

            'categories' => ['Air Fryer', 'Quick & Easy', 'Appetizers & Snack'],
        ]);

        //Jakub
        Recipe::create([
            'user_id' => $skibiBake->id,
            'title' => 'Chocolate Chip Cookies', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 20,
            'cook_time' => 12,
            'servings' => 8,
            'ingredients' => [
                '125 g unsalted butter',
                '100 g light brown sugar',
                '75 g white granulated sugar',
                '1 medium egg',
                '1 tsp vanilla (optional!)',
                '300 g plain flour', 
                '1 + 1/2 tsp baking powder', 
                '1/2 tsp bicarbonate of soda',
                '1/2 tsp sea salt', 
                '125 g dark chocolate chips', 
                '100 g of walnuts'  
            ],
            'instructions' => [
                'Add your butter and sugars to a bowl and beat until creamy - I use my stand mixer with the beater attachment',
                'Add in your egg and beat again. If using vanilla, add it in now ',
                'Add in the plain flour, baking powder, bicarbonate of soda, and salt and beat until a cookie dough is formed ',
                'Add in your dark chocolate chips, walnuts and beat till they are distributed well',
                'Weigh your cookies out into eight cookie dough balls - they are about 120g each',
                'Once they are rolled into balls, put your cookie dough in the freezer for at least 30 minutes, or in the fridge for an hour or so',
                'Whilst the cookie dough is chilling, preheat your oven to 180C Fan, or 200C regular! If your oven runs hot, go for 160C-170c.',
                'Take your cookies out of the freezer/fridge and put them onto a lined baking tray. I put four cookies per tray',
                'Bake the cookies in the oven for 12-14 minutes. I do not personally flatten the cookies, as they flatten enough during baking - however, if you like flat cookies, flatten them a bit before baking.',
                'Once baked, leave them to cool on the tray for at least 30 minutes, as they will continue to bake whilst cooling ',
                'ENJOY! '
            ],

            'categories' => ['Appetizers & Snack', 'Dessert', 'Baking'],
        ]);

        Recipe::create([
            'user_id' => $skibiBake->id,
            'title' => 'Apple Pie From Scratch ', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 15,
            'cook_time' => 60,
            'servings' => 8,
            'ingredients' => [
                '2 ½ cups flour(315 g)', 
                '1 teaspoon salt',
                '1 ½ sticks butter, 1 1/2 sticks, cold, cubed', 
                '8 tablespoons ice water, or as needed',
                '2 ½ lb granny smith apple(1 kg), cored, sliced, peeled', 
                '¾ cup sugar(150 g)',
                '2 tablespoons flour',
                '½ teaspoon salt',
                '1 teaspoon cinnamon', 
                '¼ teaspoon nutmeg',
                '½ lemon',
                '1 egg, beaten',
                '1 tablespoon sugar'
            ],
            'instructions' => [
                'In a medium-sized bowl, add the flour and salt. Mix with fork until combined. ',
                'Add in cubed butter and break up into flour with a fork. Mixture will still have lumps about the size of small peas.',
                'Gradually add the ice water and continue to mix until the dough starts to come together. You may not need all of the water, but if the dough is too dry then add more. The dough should not be very tacky or sticky.',
                'Work the dough together with your hands and turn out onto a surface. Work into a ball and cover with cling wrap. Refrigerate.',
                'Peel the apples, then core and slice',
                'In a bowl, add the sliced apples, sugar, flour, salt, cinnamon, nutmeg, and juice from the lemon. ',
                'Mix until combined and all apples are coated. Refrigerate',
                'Preheat the oven to 375°F (200°C).',
                'On a floured surface, cut the pie dough in half and roll out both halves until round and about ⅛-inch (3 mm) thick.',
                'Roll the dough around the rolling pin and unroll onto a pie dish making sure the dough reaches all edges. Trim extra if necessary. ',
                'Pour in apple filling mixture and pat down.',
                'Roll the other half of the dough on top. ',
                'Trim the extra dough from the edges and pinch the edges to create a crimp. Make sure edges are sealed together',
                'Brush the pie with the beaten egg and sprinkle with the sugar. ',
                'Cut four slits in the top of the pie to create a vent',
                'Bake pie for 50-60 minutes or until the crust is golden brown and no greyish or undercooked pastry remains. ',
                'Allow it to cool completely before slicing',
                'Enjoy! '
            ],

            'categories' => ['Dessert', 'Baking'],
        ]);
        

        Recipe::create([
            'user_id' => $skibiBake->id,
            'title' => 'Banana Bread ', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 15,
            'cook_time' => 60,
            'servings' => 12,
            'ingredients' => [
                '2 cups all-purpose flour', 
                '1 teaspoon baking soda',
                '¼ teaspoon salt ',
                '¾ cup brown sugar ',
                '½ cup butter ',
                '2 large eggs, beaten', 
                '2 ⅓ cups mashed overripe bananas' 
            ],
            'instructions' => [
                'Gather all ingredients. Preheat the oven to 350 degrees F (175 degrees C). Lightly grease a 9x5-inch loaf pan.', 
                'Pour batter into the prepared loaf pan.', 
                'Bake in the preheated oven until a toothpick inserted into the center comes out clean, about 60 minutes.',
                'Let bread cool in pan for 10 minutes, then turn out onto a wire rack to cool completely.',
                'Enjoy! '
            ],

            'categories' => ['Dessert', 'Baking', 'Appetizers & Snack'],
        ]);

        Recipe::create([
            'user_id' => $skibiBake->id,
            'title' => 'Easy Spagetti Bolognese', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 30,
            'cook_time' => 90,
            'servings' => 4,
            'ingredients' => [
                '2 tbsp olive oil',
                '400g/14oz beef mince', 
                '1 onion, diced ',
                '2 garlic cloves, chopped',
                '100g/3½oz carrot, grated ',
                '2 x 400g tins chopped tomatoes', 
                '400ml/14fl oz stock (made from stock cube. Ideally beef, but any will do)', 
                '400g/14oz dried spaghetti', 
                'salt and pepper'
            ],
            'instructions' => [
                'Heat a large saucepan over medium heat. Add a tablespoon of olive oil and once hot add the minced beef and a pinch of salt and pepper. Cook the mince until well browned over a medium-high heat (be careful not to burn the mince. It just needs to be a dark brown colour). Once browned, transfer the mince to a bowl and set aside.',
                'Add another tablespoon of oil to the saucepan you browned the mince in and turn the heat to medium. Add the onions and a pinch of salt and fry gently for 5-6 minutes, or until softened and translucent. Add the garlic and cook for another 2 minutes. Add the grated carrot then pour the mince and any juices in the bowl back into the saucepan.',
                'Add the tomatoes to the pan and stir well to mix. Pour in the stock, bring to a simmer and then reduce the temperature to simmer gently for 45 minutes, or until the sauce is thick and rich. Taste and adjust the seasoning as necessary.', 
                'When ready to cook the spaghetti, heat a large saucepan of water and add a pinch of salt. Cook according to the packet instructions. Once the spaghetti is cooked through, drain and add to the pan with the Bolognese sauce. Mix well and serve.' 
            ],

            'categories' => ['Dinner', 'Lunch'],
        ]);

        Recipe::create([
            'user_id' => $skibiBake->id,
            'title' => 'Bryndza dumplings with bacon', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 35,
            'cook_time' => 45,
            'servings' => 6,
            'ingredients' => [
                '150 g Bacon ',
                '500 g potatoes', 
                '250 g plain flour', 
                '1 egg', 
                'Salt (Belbake)', 
                '200 g bryndza (Slovak sheep cheese)', 
                '200 g sour cream'
            ],
            'instructions' => [
                'Prepare the bacon - Cut the bacon into small cubes and fry it in a pot until crispy', 
                'Make the dough - Peel, wash, and finely grate the potatoes. Add flour and the egg, then mix thoroughly until you get a thick batter.', 
                'Cook the dumplings - Bring a large pot of salted water to a boil. Using a dumpling strainer and scraper, press the batter through into the boiling water. Stir well to prevent the dumplings from sticking together.', 
                'Boil until done - Cook the dumplings until they rise to the surface (about 3 minutes). Drain them in a strainer.',
                'Mix with bryndza and sour cream -In a large bowl, mix the bryndza cheese with sour cream. Add the cooked dumplings and gently combine.', 
                'Serve dumplings topped with crispy bacon.', 
                'Enjoy!' 
            ],

            'categories' => ['Dinner', 'Lunch'],
        ]);

        //elly 
        Recipe::create([
            'user_id' => $elly->id,
            'title' => 'Garlic Butter Shrimp Scampi ', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 10,
            'cook_time' => 10,
            'servings' => 2,
            'ingredients' => [
                '1 lb large shrimp, peeled and deveined', 
                '4 Tbsp unsalted butter', 
                '4 cloves garlic, minced', 
                '1/4 cup dry white wine (or chicken broth)', 
                '1 Tbsp lemon juice', 
                '1/4 tsp red pepper flakes (optional)', 
                '2 Tbsp fresh parsley, chopped', 
                'Salt and black pepper to taste', 
                'Served over pasta or with crusty bread (optional)' 
            ],
            'instructions' => [
                'Prep Shrimp: Pat the shrimp dry and season with salt and pepper.', 
                'Sauté Garlic: Melt butter in a large skillet over medium heat. Add garlic and red pepper flakes (if using) and cook for 1 minute until fragrant.', 
                'Add Wine/Broth: Pour in the white wine (or broth) and lemon juice. Bring to a simmer and cook for 2 minutes.',
                'Cook Shrimp: Add the seasoned shrimp to the skillet. Cook for about 1-2 minutes per side, until pink and opaque. Do not overcook.', 
                'Finish: Stir in the fresh parsley. Serve immediately over linguine or with bread for dipping.'
            ],

            'categories' => ['Dinner', 'Seafood'],
        ]);
        Recipe::create([
            'user_id' => $elly->id,
            'title' => 'Simple Tomato Bruschetta', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 15,
            'cook_time' => 5,
            'servings' => 4,
            'ingredients' => [
                '1 baguette, sliced into 1/2-inch pieces', 
                '2 Tbsp olive oil (for bread)', 
                '2 cups diced ripe tomatoes', 
                '2 cloves garlic, minced', 
                '1/4 cup fresh basil, chopped', 
                '2 Tbsp balsamic glaze (optional, for drizzling)', 
                '1 Tbsp extra virgin olive oil (for topping)', 
                'Salt and pepper to taste'
            ],
            'instructions' => [
                'Toast Bread: Preheat oven to $350^\circ\text{F}$ ($175^\circ\text{C}$). Brush baguette slices with 2 Tbsp olive oil and toast on a baking sheet for 5-7 minutes until lightly golden. ',
                'Prepare Topping: In a bowl, combine the diced tomatoes, minced garlic, chopped basil, 1 Tbsp extra virgin olive oil, salt, and pepper.', 
                'Assemble: Spoon the tomato mixture generously onto each toasted bread slice.', 
                'Serve: Drizzle with balsamic glaze, if desired, and serve immediately.'
            ],

            'categories' => ['Appetizers & Snack', 'Quick & Easy', 'Vegetarian'],
        ]);

        Recipe::create([
            'user_id' => $elly->id,
            'title' => 'One-Pan Lemon Herb Roasted Chicken & Veggies', 
            'description' => null, //change 
            'image' => null,  //change
            'prep_time' => 15,
            'cook_time' => 5,
            'servings' => 4,
            'ingredients' => [
                
            ],
            'instructions' => [
                
            ],

            'categories' => ['Dinner', 'Healthy'],
        ]);*/
    }
}
