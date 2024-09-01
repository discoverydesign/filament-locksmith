<?php

namespace DiscoveryDesign\FilamentLocksmith\Forms\Components\Generators;

use Filament\Forms;
use Illuminate\Support\Str;

class RandomGenerator extends BaseGenerator
{
    public string $name = 'Random Password';

    public function __construct()
    {
        $this->setOptions([
            Forms\Components\TextInput::make('random_length')
                ->label('Length')
                ->default(16)
                ->type('number')
                ->required()
                ->minValue(8)
                ->maxValue(100),
            Forms\Components\Toggle::make('random_numbers')
                ->label('Numbers')
                ->default(true),
            Forms\Components\Toggle::make('random_symbols')
                ->label('Symbols')
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

