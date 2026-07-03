<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->singleton('cart', function ($app) {
        return new \App\Helpers\CartHelper();
        });

    }

    public function boot(): void
    {
         if (config('app.env') === 'production') 
        \URL::forceScheme('https');
    }
}
