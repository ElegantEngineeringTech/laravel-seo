<?php

declare(strict_types=1);

namespace Elegantly\Seo\Tests;

use Elegantly\Seo\SeoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            SeoServiceProvider::class,
        ];
    }
}
