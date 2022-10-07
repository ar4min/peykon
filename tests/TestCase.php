<?php

namespace Ar4min\PayKon\Tests;

use Ar4min\PayKon\PayKonServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [PayKonServiceProvider::class];
    }
}
