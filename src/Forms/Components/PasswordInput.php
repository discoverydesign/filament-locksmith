<?php

namespace DiscoveryDesign\FilamentLocksmith\Forms\Components;

use DiscoveryDesign\FilamentLocksmith\Forms\Components\Generators\MemorableGenerator;
use DiscoveryDesign\FilamentLocksmith\Forms\Components\Generators\PinGenerator;
use DiscoveryDesign\FilamentLocksmith\Forms\Components\Generators\RandomGenerator;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\MaxWidth;
use GenPhrase\Password;

class PasswordInput extends TextInput
{
    public bool $isCopyable = false;

    public bool $isEditable = false;

    public bool $isGeneratable = true;

    public bool $isHashed = true;

    public bool $isAdvanced = false;

    public array $generators = [];

    public ?\Closure $generatorFn = null;

    protected function setUp(): void
    {
        $this->password();

        $this->generators[] = new RandomGenerator;
        $this->generators[] = new MemorableGenerator;
        $this->generators[] = new PinGenerator;
    }

    public function getExtraInputAttributes(): array
    {
        $extraAttributes = parent::getExtraInputAttributes();

        // We do it this way so it doesn't visually mess with the input container
        if (! $this->isEditable) {
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
                    $tooltipText = __('filament-locksmith::locksmith.copied');

                    return <<<JS
                        window.navigator.clipboard.writeText(\$wire.get('{$component->getStatePath()}'));

                        \$tooltip('{$tooltipText}');
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
            if (! $this->isHashed) {
                return;
            }

            $set($component->getName(), \Hash::make($get($component->getName())));
        });

        return $this;
    }

    public function advanced($state = true)
    {
        $this->isAdvanced = $state;
        $this->generatable();

        return $this;
    }

    public function addGenerator($generator)
    {
        $this->generators[] = $generator;

        return $this;
    }

    public function setGenerators($generators)
    {
        $this->generators = $generators;

        return $this;
    }

    public function getGenerators()
    {
        return $this->generators;
    }

    public function generatable()
    {
        $this->isGeneratable = true;

        if ($this->isAdvanced) {
            $this->suffixAction(
                Action::make('generatePassword')
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->label(__('filament-locksmith::locksmith.generate'))
                    ->form(function () {
                        $options = [];
                        $fields = [];
                        foreach ($this->getGenerators() as $generator) {
                            $options[$generator->name] = $generator->name;

                            foreach ($generator->getOptions() as $field) {
                                $fields[] = $field
                                    ->visible(fn ($get) => $get('type') === $generator->name)
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (?string $state, ?string $old, $get, $set) use ($generator) {
                                        $set('password', $generator->generate($get));
                                    });
                            }
                        }

                        return [
                            Forms\Components\TextInput::make('password')
                                ->label('')
                                ->extraAttributes(['disabled' => '']),
                            Forms\Components\Select::make('type')
                                ->afterStateUpdated(function (?string $state, $get, $set) {
                                    $generators = collect($this->getGenerators());
                                    $generator = $generators->first(fn ($generator) => $generator->name === $state);

                                    if ($generator) {
                                        $set('password', $generator->generate($get));
                                    }
                                })
                                ->options($options)
                                ->live(),
                            ...$fields,
                        ];
                    })
                    ->action(function($data, Set $set, Component $component) {
                        $set($component->getName(), $data['password']);
                    })
                    ->modalSubmitAction(fn (StaticAction $action) => $action->label(__('filament-locksmith::locksmith.use')))
                    ->modalWidth(MaxWidth::Medium)
                    ->visible($this->isGeneratable)
            );

            return $this;
        } else {
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
        }

        return $this;
    }

    public function generator(?\Closure $generator = null)
    {
        $this->generatorFn = $generator;

        return $this;
    }

    // A preloaded generator function that generates a password using friendly names
    public function friendly()
    {
        $this->generator(function () {
            $gen = new Password;
            $gen->disableSeparators(true);
            $gen->disableWordModifier(true);

            return Str($gen->generate(36))->replace(' ', '-');
        });

        return $this;
    }

    public function createPassword()
    {
        if ($this->generatorFn) {
            return $this->evaluate($this->generatorFn);
        }

        return \Str::password();
    }
}
