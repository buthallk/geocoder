<?php

namespace Yuraplohov\LaravelExample\Test;

class CommandTest extends FeatureTestCase
{
    protected function getEnvironmentSetUp($Geocoder)
    {
        parent::getEnvironmentSetUp($Geocoder);

        $Geocoder['config']->set('example.param', 200);
    }

    /**
     * @test
     */
    public function it_executes_example_command()
    {
        $output = $this->artisan('example-command');

        $output->assertExitCode(0);

        $output->expectsOutput("Command executed with config param value 200");
    }
}