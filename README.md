# Filament Locksmith

🔒 A complete password input field 🤫

![Packagist Version](https://img.shields.io/packagist/v/discoverydesign/filament-locksmith.svg)
![Total Downloads](https://img.shields.io/packagist/dt/discoverydesign/filament-locksmith.svg)

This package allows you to add a feature rich password filed for Filament PHP.

https://packagist.org/packages/discoverydesign/filament-locksmith

## How to use
1. Install the package using `composer require discoverydesign/filament-locksmith`
4. Import the package inside your Filament Form with `use DiscoveryDesign\FilamentLocksmith\Forms\Components\PasswordInput`.
5. Add the `PasswordInput` form component to your form with `PasswordInput::make()`.
6. If required, publish the translation files with `php artisan vendor:publish --tag=filament-locksmith-translations`.

## Examples

### Example
```php
<?php

namespace App\Filament\Resources;

use DiscoveryDesign\FilamentGaze\Forms\Components\GazeBanner;
// ...

class UserResource extends Resource
{
    // ...

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                PasswordInput::make('password')
                    ->required()
                    ->generatable()
                    ->editable(false)
                    ->friendly()
                    ->copyable()
                    ->revealable(),
                    
                // ...
            ]);
    }
    
    // ...
}
```


## Docs

### `->generatable($state)`

#### Description
`generatable` can be used to set if this password field should allow for an automatic password to be generated. this by default will generate a 32 character random string.

#### Arguments
`state` - (optional, bool) If the password should be generatable.

### `->friendly()`

#### Description
`friendly` is a preloaded generator that creates a user friendly password. This password consists of 3 words that are combinred with '-'.

### `->copyable($state)`

#### Description
`copyable` can be used to set if this password field should copyable to clipboard.

#### Arguments
`state` - (optional, bool) If the password should be copyable.

### `->editable($state)`

#### Description
`editable` can be used to block the password field being edited. This is normally combined with `->generatable()`.

#### Arguments
`state` - (optional, bool) If the password should be editable.



## Author

🚀 [Discovery Design](https://discoverydesign.co.uk)

