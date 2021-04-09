Billplz adapter for Laravel
==============

[![tests](https://github.com/jomweb/billplz-laravel/workflows/tests/badge.svg?branch=1.x)](https://github.com/jomweb/billplz-laravel/actions?query=workflow%3Atests+branch%3A1.x)
[![Latest Stable Version](https://poser.pugx.org/jomweb/billplz-laravel/version)](https://packagist.org/packages/jomweb/billplz-laravel)
[![Total Downloads](https://poser.pugx.org/jomweb/billplz-laravel/downloads)](https://packagist.org/packages/jomweb/billplz-laravel)
[![Latest Unstable Version](https://poser.pugx.org/jomweb/billplz-laravel/v/unstable)](//packagist.org/packages/jomweb/billplz-laravel)
[![License](https://poser.pugx.org/jomweb/billplz-laravel/license)](https://packagist.org/packages/jomweb/billplz-laravel)
[![Coverage Status](https://coveralls.io/repos/github/jomweb/billplz-laravel/badge.svg?branch=master)](https://coveralls.io/github/jomweb/billplz-laravel?branch=master)

## Installation

To install through composer by using the following command:

    composer require "jomweb/billplz-laravel"

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

## Usages

### Creating Client

With `jomweb/billplz-laravel` you have the option to initiate the client using the following methods.

#### Facade

```php
use Billplz\Laravel\Billplz;

$bill = Billplz::bill()->create( /* ... */ );
```

#### IoC

```php
$bill = resolve('billplz')->bill()->create( /* ... */ );
```

#### Dependency Injection

```php
use Billplz\Client;

// ...

public function createBill(Client $client)
{
    $bill = $client->bill()->create( /* ... */ );

}
```

