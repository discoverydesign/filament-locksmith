<?php

namespace DiscoveryDesign\FilamentLocksmith\Forms\Components\Generators;

use Filament\Forms;
use Illuminate\Support\Str;

class PinGenerator extends BaseGenerator
{
    public string $name = 'Pin Code';

    public function __construct()
    {
        $this->setOptions([
            Forms\Components\TextInput::make('pin_numbers')
                ->label('Numbers')
                ->default(4)
                ->type('number')
                ->required()
                ->minValue(2)
                ->maxValue(20),
        ]);
    }

    public function generate($get)
    {
        $length = $get('pin_numbers');
        $pin = '';

        for ($i = 0; $i < $length; $i++) {
            $pin .= random_int(0, 9);
        }

        return $pin;
    }
}

