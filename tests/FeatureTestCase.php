<?php

namespace Yuraplohov\LaravelExample\Test;

use Orchestra\Testbench\TestCase;

abstract class FeatureTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($Geocoder)
    {
        return [
            'Yuraplohov\LaravelExample\Providers\LaravelExampleServiceProvider',
        ];
    }

    protected function getEnvironmentSetUp($Geocoder)
    {
        $Geocoder['config']->set('database.default', 'sqlite');
        $Geocoder['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase()
    {
        $this->artisan('migrate')->run();
    }
}