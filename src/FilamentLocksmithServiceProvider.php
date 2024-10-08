<?php

namespace DiscoveryDesign\FilamentLocksmith;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * Class FilamentLocksmithServiceProvider
 *
 * @package DiscoveryDesign\FilamentLocksmith
 */
class FilamentLocksmithServiceProvider extends PackageServiceProvider
{
    /**
     * The name of the package.
     *
     * @var string
     */
    public static string $name = 'filament-locksmith';

    /**
     * Configure the package.
     *
     * @param Package $package
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-locksmith')
            ->hasTranslations();
    }
}
