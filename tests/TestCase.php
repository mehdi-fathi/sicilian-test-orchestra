<?php

namespace Tests;


use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
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

    }


    /**
     * @return void
     */
    protected function runDatabaseMigrations()
    {
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

    /**
     * @return mixed
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
