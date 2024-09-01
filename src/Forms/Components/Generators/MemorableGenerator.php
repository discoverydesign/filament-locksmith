<?php

namespace DiscoveryDesign\FilamentLocksmith\Forms\Components\Generators;

use Filament\Forms;
use GenPhrase\Password;
use Illuminate\Support\Str;

class MemorableGenerator extends BaseGenerator
{
    public string $name = 'Memorable Password';

    public function __construct()
    {
        $this->setOptions([
            Forms\Components\TextInput::make('memorable_words')
                ->label('Words')
                ->default(3)
                ->type('number')
                ->required()
                ->minValue(3)
                ->maxValue(20),
            Forms\Components\Select::make('memorable_separator')
                ->label('Separator')
                ->options([
                    '-' => 'Hyphen',
                    '_' => 'Underscore',
                    ' ' => 'Space',
                    '.' => 'Period',
                    ',' => 'Comma',
                ])
                ->default('-')
        ]);
    }

    public function generate($get)
    {
        $length = $get('memorable_words');
        $separator = $get('memorable_separator');

        $gen = new Password;
        $wordList = $gen->getWordlistHandler()->getWordsAsArray();

        $words = collect();

        for($i = 0; $i < $length; $i++) {
            $words->push($wordList[array_rand($wordList)]);
        }


        return $words->implode($separator);
    }
}

