<?php

declare(strict_types=1);

namespace Rushing\BlockSchema;

use Rushing\BlockSchema\Contracts\Schema;
use Rushing\BlockSchema\Schema\NodeSchema;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-block-schema');
    }

    public function registeringPackage(): void
    {
        // An empty node-type registry. The app registers its concrete Block types.
        $this->app->singleton(Schema::class, NodeSchema::class);

        $this->app->bind(
            DocumentHydrator::class,
            fn ($app) => new DocumentHydrator($app->make(Schema::class)),
        );
    }
}
