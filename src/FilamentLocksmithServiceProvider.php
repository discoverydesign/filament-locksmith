<?php

namespace DiscoveryDesign\FilamentLocksmith;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * Class FilamentGazeServiceProvider
 *
 * @package DiscoveryDesign\FilamentGaze
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
            ->hasTranslations()
            ->hasViews();
    }

    /**
     * Perform any actions after the package has booted.
     *
     * @return void
     */
    public function packageBooted(): void {
        FilamentAsset::register([
            Css::make('filament-locksmith-stylesheet', __DIR__ . '/../dist/filament-locksmith.css'),
        ]);
    }
}
