# Filament Locksmith

🔒 Passwords made easy in Filament PHP 🤫

![Basic Example](https://raw.githubusercontent.com/discoverydesign/filament-locksmith/main/media/2.png)

![Packagist Version](https://img.shields.io/packagist/v/discoverydesign/filament-locksmith.svg)
![Total Downloads](https://img.shields.io/packagist/dt/discoverydesign/filament-locksmith.svg)

This package allows you to add a feature rich password field for Filament PHP.

https://packagist.org/packages/discoverydesign/filament-locksmith

## How to use
1. Install the package using `composer require discoverydesign/filament-locksmith`
2. Import the package inside your Filament Form with `use DiscoveryDesign\FilamentLocksmith\Forms\Components\PasswordInput`.
3. Add the `PasswordInput` form component to your form with `PasswordInput::make()`.
4. If required, publish the translation files with `php artisan vendor:publish --tag=filament-locksmith-translations`.

## Examples

### Example
```php
<?php

namespace App\Filament\Resources;

use DiscoveryDesign\FilamentLocksmith\Forms\Components\PasswordInput;
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
`generatable` can be used to set if this password field should allow for an automatic password to be generated. This by default will generate a 32 character random string.

#### Arguments
`state` - (optional, bool) If the password should be generatable.

### `->friendly()`

#### Description
`friendly` is a preloaded generator that creates a user friendly password. This password consists of 3 words that are combinred with '-'. E.g `time-shelf-bottle`

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

### `->generator($func)`

#### Description
`generator` allows you to define a custom generator that is used to create a password.

#### Arguments
`func` - (optional, closure) The function used to generate the password. This function **must** return a string.

### `->hashed($state)`

#### Description
`hashed` can be used if the password should be hashed before being stored. **In most cases, you should instead use a cast against your model.**

#### Arguments
`state` - (optional, bool) If the password should be hashed.

### `->revealable($func)`

#### Description
`revealable` can be used to allow the password to be revealed. This is just Filament's built in reveal functionality.

#### Arguments
`func` - (optional, closure, bool) If the password should be revealable. If a closure is passed, this should return a bool.


## Author

🚀 [Discovery Design](https://discoverydesign.co.uk)

