<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add helper for time formatting
        Blade::directive('formatTime', function ($minutes) {
            return "<?php 
                \$mins = $minutes;
                if (\$mins >= 60) {
                    \$hours = floor(\$mins / 60);
                    \$remainingMins = \$mins % 60;
                    echo \$hours . 'h' . (\$remainingMins > 0 ? ' ' . \$remainingMins . 'm' : '');
                } else {
                    echo \$mins . 'm';
                }
            ?>";
        });



            $categories = \DB::table('recipes')
        ->select('categories')
        ->get()
        ->flatMap(fn($r) => json_decode($r->categories, true))
        ->unique()
        ->values();

    view()->share('categories', $categories);
}
    }

