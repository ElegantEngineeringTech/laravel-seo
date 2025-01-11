<?php

declare(strict_types=1);

namespace Elegantly\Seo;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SeoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-seo')
            ->hasConfigFile()
            ->hasViews();
    }

    public function registeringPackage(): void
    {
        $this->app->scoped(SeoManager::class, function () {
            return SeoManager::default();
        });
    }
}
