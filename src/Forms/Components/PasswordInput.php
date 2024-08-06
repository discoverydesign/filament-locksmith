<?php

namespace DiscoveryDesign\FilamentLocksmith\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Component;
use GenPhrase\Password;

class PasswordInput extends TextInput
{
    public bool $isCopyable = false;
    public bool $isEditable = false;
    public bool $isGeneratable = true;
    public bool $isHashed = true;

    public ?\Closure $generatorFn = null;

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
            $this->placeholder(__('filament-locksmith::locksmith.generate'));
        }

        return $extraAttributes;
    }

    public function copyable($state = true)
    {
        $this->isCopyable = $state;

        $this->suffixAction(
            Action::make('copy')
                ->icon('heroicon-m-clipboard')
                ->color('gray')
                ->alpineClickHandler(function (Component $component) {
                    return <<<JS
                        window.navigator.clipboard.writeText(\$wire.get('{$component->getStatePath()}'));

                        \$tooltip({__('filament-locksmith::locksmith.copied')});
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

    // If not using a cast, hash it for them
    public function hashed($state = true)
    {
        $this->isHashed = $state;

        $this->before(function (Set $set, Get $get, Component $component) {
            if (!$this->isHashed) return;

            $set($component->getName(), \Hash::make($get($component->getName())));
        });

        return $this;
    }

    public function generatable()
    {
        $this->isGeneratable = true;

        $this->suffixAction(
            Action::make('generatePassword')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(function(Set $set, Component $component) {
                    $password = $this->createPassword();

                    $set($component->getName(), $password);
                })
                ->visible($this->isGeneratable)
        );

        return $this;
    }

    public function generator(\Closure|null $generator = null)
    {
        $this->generatorFn = $generator;

        return $this;
    }

    // A preloaded generator function that generates a password using friendly names
    public function friendly()
    {
        $this->generator(function () {
            $gen = new Password();
            $gen->disableSeparators(true);
            $gen->disableWordModifier(true);

            return Str($gen->generate(36))->replace(' ', '-');
        });

        return $this;
    }

    public function createPassword()
    {
        if ($this->generatorFn) {
            return ($this->generatorFn)();
        }

        return \Str::password();
    }
}
