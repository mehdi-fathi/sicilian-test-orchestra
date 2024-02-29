<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        // $this->loadRoutesFrom(__DIR__.'/web.php');

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/web.php');

        $this->publishes([
            __DIR__ . '../../src/migrations/' => database_path('migrations/my-package'),
        ], 'my-package-migrations');

    }

}
