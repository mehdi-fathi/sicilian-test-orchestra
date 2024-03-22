<?php

namespace SicilianTestOrchestra;


use Illuminate\Support\ServiceProvider;


/**
 *
 */
class SicilianTestOrchestraServiceProvider extends ServiceProvider
{


    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {

        $this->publishes([
            __DIR__ . '/../Tests/Tests/migrations/2024_02_28_163404_report_tests.php' => database_path('migrations/2024_02_28_163404_report_tests.php'),
        ], 'migrations');

    }

}
