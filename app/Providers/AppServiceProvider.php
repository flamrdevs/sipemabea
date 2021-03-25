<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Laravel
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('pagination.paginate');
        // Paginator::defaultSimpleView('pagination.simple-paginate');
    }
}