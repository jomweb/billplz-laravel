Billplz adapter for Laravel
==============

[![Build Status](https://travis-ci.org/jomweb/billplz-laravel.svg?branch=master)](https://travis-ci.org/jomweb/billplz-laravel)
[![Latest Stable Version](https://poser.pugx.org/jomweb/billplz-laravel/version)](https://packagist.org/packages/jomweb/billplz-laravel)
[![Total Downloads](https://poser.pugx.org/jomweb/billplz-laravel/downloads)](https://packagist.org/packages/jomweb/billplz-laravel)
[![Latest Unstable Version](https://poser.pugx.org/jomweb/billplz-laravel/v/unstable)](//packagist.org/packages/jomweb/billplz-laravel)
[![License](https://poser.pugx.org/jomweb/billplz-laravel/license)](https://packagist.org/packages/jomweb/billplz-laravel)

* [Installation](#installation)
* [Configuration](#configuration)

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "jomweb/billplz-laravel": "^1.0"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "jomweb/billplz-laravel=^1.0"

## Configuration

Next add the service provider in `config/app.php`.

```php
'providers' => [

    // ...

    Billplz\Laravel\BillplzServiceProvider::class,

],
```

### Aliases

You might want to add `Billplz\Laravel\Billplz` to class aliases in `config/app.php`:

```php
'aliases' => [

    // ...

    'Billplz' => Billplz\Laravel\Billplz::class,

],
```

### Billplz Configuration

Next add the configuration in `config/services.php`.

```php
<?php 

return [

    // ...

    'billplz' => [
        'key' => env('BILLPLZ_API_KEY'),
        'version' => env('BILLPLZ_VERSION', 'v4'),
        'x-signature' => env('BILLPLZ_X_SIGNATURE'),
        'sandbox' => env('BILLPLZ_SANDBOX', false),
    ],
];
```
