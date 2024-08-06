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
    public bool $isCopyable = false;
    public bool $isEditable = false;

    protected function setUp(): void
    {
        $this->password();

    }

    public function getExtraInputAttributes(): array
    {
        $extraAttributes = parent::getExtraInputAttributes();

        // We do it this way so it doesn't visually mess with the input container
        if (!$this->isEditable) {
            $extraAttributes['disabled'] = '';
            $this->placeholder('Generate Password');
        }

        return $extraAttributes;
    }

    public function copyable($state = true)
    {
        $this->isCopyable = $state;

        $this->suffixAction(
            Action::make('copyCostToPrice')
                ->icon('heroicon-m-clipboard')
                ->color('gray')
                ->alpineClickHandler(function (Component $component) {
                    return <<<JS
                        window.navigator.clipboard.writeText(\$wire.get('{$component->getStatePath()}'));

                        \$tooltip('Password copied');
                    JS;
                })
                ->visible($this->isCopyable)
        );

        return $this;
    }

    public function editable($state = true)
    {
        $this->isEditable = $state;

        return $this;
    }
}
