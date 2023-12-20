<?php

namespace Tests;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 *
 */
class ServiceProviderTest extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {

        $this->loadRoutesFrom(__DIR__.'/web.php');

    }

}
