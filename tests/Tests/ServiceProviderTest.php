<?php

namespace Tests;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;


/**
 *
 */
class ServiceProviderTest extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {

        // Set the application key for testing
        $this->app['config']->set('app.key', 'base64:MY00Niv+f1zqSqzguol9ntjGJJQ/pFvRXB7WXwFOc2s=');

        // $this->loadRoutesFrom(__DIR__.'/web.php');

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/web.php');

    }

}
