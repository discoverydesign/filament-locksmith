<?php

namespace DiscoveryDesign\FilamentLocksmith\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Set;
use Filament\Forms\Components\Component;

/**
 * Class GazeBanner
 *
 * Represents a custom form component called GazeBanner.
 * This component displays a banner with the names of the current viewers.
 * It provides methods to set a custom identifier and the poll timer.
 * The component refreshes the list of viewers and renders the banner.
 */
class PasswordInput extends TextInput
{

    protected function setUp(): void
    {
        $this->password();

    }
}
