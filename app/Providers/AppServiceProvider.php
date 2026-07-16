<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('cart', function () {
            return new CartService();
        });
    }

    public function boot(): void
    {
       
    if (app()->environment('production')) {
        \URL::forceScheme('https');
    }
    
    }

}
