<?php

namespace DiscoveryDesign\FilamentLocksmith\Generators;

use Filament\Forms;
use GenPhrase\Password;
use Illuminate\Support\Str;

class MemorableGenerator extends BaseGenerator
{
    public string $name = '';

    public function __construct()
    {
        $this->name = __('filament-locksmith::locksmith.memorable.title');

        $this->setOptions([
            Forms\Components\TextInput::make('memorable_words')
                ->label(__('filament-locksmith::locksmith.memorable.words'))
                ->default(3)
                ->type('number')
                ->required(),
            Forms\Components\Select::make('memorable_separator')
                ->label(__('filament-locksmith::locksmith.memorable.separator'))
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

