<?php

namespace Lester\ProactiveAlert\Tests;

use Orchestra\Testbench\TestCase;
use Lester\ProactiveAlert\Facades\Proactive;
use Lester\ProactiveAlert\ServiceProvider;

class ProactiveTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function testFacade()
    {

        Proactive::test();

    }
}
