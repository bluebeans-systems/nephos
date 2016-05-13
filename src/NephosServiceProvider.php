<?php

namespace BluebeansSystems\Nephos;

use Illuminate\Support\ServiceProvider;

class NephosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';

        $this->app->bind('nephos', function() {
            return new Nephos();
        });
    }
}
