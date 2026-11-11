<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
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
        // Partager les variables d'assets avec toutes les vues
        \View::composer('*', function ($view) {
            $view->with([
                'faqbsAssets' => [
                    'css' => [
                        asset('css/app.css'),
                    ],
                    'js' => [
                        asset('js/app.js'),
                    ],
                ],
            ]);
        });
    }
}
