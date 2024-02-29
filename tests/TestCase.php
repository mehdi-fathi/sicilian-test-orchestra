<?php

namespace Tests;


use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sail\SailServiceProvider;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Orchestra\Canvas\Core\Concerns\MigrationGenerator;

/**
 * Class TestCase.
 */
class TestCase extends \Orchestra\Testbench\TestCase
{

    use DatabaseMigrations;
    /**
     * @var m\LegacyMockInterface|m\MockInterface
     */

    public function setUp(): void
    {

        parent::setUp();

        $this->app->register(\Tests\ServiceProviderTest::class); // Register your service provider


        // $this->loadMigrationsFrom([
        //     '/Users/mehdi/Sites/sicilian-test-orchestra/2024_02_28_163404_users',
        //
        // ]);

        // $this->publishes([
        //     '/Users/mehdi/Sites/sicilian-test-orchestra' => database_path('migrations'),
        // ], 'migrations');

        // $this->app->register(RouteServiceProvider::class); // Register your service provider

    }


    protected function runDatabaseMigrations()
    {
        // Set the custom path for your migrations
        $customMigrationPath = '/Users/mehdi/Sites/sicilian-test-orchestra/tests/Tests/migrations';

        // dump($customMigrationPath);


        $this->artisan('migrate:fresh', [
            '--path' => '../../../tests/Tests/migrations',
        ]);

        $this->app[Kernel::class]->setArtisan(null);
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
