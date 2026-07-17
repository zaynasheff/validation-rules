<?php

namespace Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Zaynasheff\ValidationRules\ValidationRulesServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ValidationRulesServiceProvider::class,
        ];
    }
}
