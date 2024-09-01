<?php

namespace DiscoveryDesign\FilamentLocksmith;

use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use DiscoveryDesign\FilamentLocksmith\Pages\PasswordAndSecurity;

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
            ->hasViews()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                MenuItem::make()
                    ->label('Password & Security')
                    ->url(PasswordAndSecurity::getUrl())
                    ->icon('heroicon-s-lock-closed'),
            ]);
        });
    }
}
