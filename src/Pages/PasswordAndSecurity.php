<?php

namespace DiscoveryDesign\FilamentLocksmith\Pages;

use Filament\Pages\Page;

class PasswordAndSecurity extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';
    protected static string $view = 'filament-locksmith::pages.password-and-security';
    protected static ?string $navigationLabel = 'Password & Security';
    protected static ?string $slug = 'password-and-security';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
