<?php

namespace Tests;


use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;


/**
 * Class TestCase.
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var m\LegacyMockInterface|m\MockInterface
     */

    public function setUp(): void
    {
        parent::setUp();
        $this->app->register(\Tests\ServiceProviderTest::class); // Register your service provider

        // $this->app->register(RouteServiceProvider::class); // Register your service provider

    }


    /**
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [\Tests\ServiceProviderTest::class];
    }

    public function createApplication()
    {
        // TODO: Implement createApplication() method.

        $app = require '/Users/mehdi/Sites/sicilian-test-orchestra/vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();


        return $app;
    }
}
