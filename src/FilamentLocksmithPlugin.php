<?php

namespace DiscoveryDesign\FilamentLocksmith;

use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use DiscoveryDesign\FilamentLocksmith\Pages\PasswordAndSecurity;

/**
 * Class FilamentLocksmithPlugin
 *
 * This class represents the Filament Locksmith plugin.
 * It implements the Plugin interface and provides methods for booting and registering the plugin.
 */
class FilamentLocksmithPlugin implements Plugin
{
    /**
     * Create a new instance of the plugin.
     *
     * @return static
     */
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * Get the ID of the plugin.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'filament-locksmith';
    }

    /**
     * Boot the plugin.
     *
     * @param Panel $panel The Filament panel instance.
     * @return void
     */
    public function boot(Panel $panel): void {
        $panel->userMenuItems([
           MenuItem::make()
               ->label('Password & Security')
               ->url(fn() => PasswordAndSecurity::getUrl())
               ->icon('heroicon-s-lock-closed')
        ]);
    }

    /**
     * Register the plugin.
     *
     * @param Panel $panel The Filament panel instance.
     * @return void
     */
    public function register(Panel $panel): void {
        $panel->pages([
            PasswordAndSecurity::class,
        ]);
    }
}
