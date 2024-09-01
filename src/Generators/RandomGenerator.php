<?php

namespace DiscoveryDesign\FilamentLocksmith\Generators;

use Filament\Forms;
use Illuminate\Support\Str;

class RandomGenerator extends BaseGenerator
{
    public string $name = 'Random Password';

    public function __construct()
    {
        $this->name = __('filament-locksmith::locksmith.random.title');

        $this->setOptions([
            Forms\Components\TextInput::make('random_length')
                ->label(__('filament-locksmith::locksmith.random.length'))
                ->default(16)
                ->type('number')
                ->required(),
            Forms\Components\Toggle::make('random_numbers')
                ->label(__('filament-locksmith::locksmith.random.numbers'))
                ->default(true),
            Forms\Components\Toggle::make('random_symbols')
                ->label(__('filament-locksmith::locksmith.random.symbols'))
                ->default(true),
        ]);
    }

    public function generate($get)
    {
        $length = $get('random_length');
        $numbers = $get('random_numbers');
        $symbols = $get('random_symbols');

        return Str::password($length, true, $numbers, $symbols);
    }
}

