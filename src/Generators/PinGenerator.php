<?php

namespace DiscoveryDesign\FilamentLocksmith\Generators;

use Filament\Forms;
use Illuminate\Support\Str;

class PinGenerator extends BaseGenerator
{
    public string $name = 'Pin Code';

    public function __construct()
    {
        $this->name = __('filament-locksmith::locksmith.pin.title');

        $this->setOptions([
            Forms\Components\TextInput::make('pin_numbers')
                ->label(__('filament-locksmith::locksmith.pin.numbers'))
                ->default(4)
                ->type('number')
                ->required()
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

