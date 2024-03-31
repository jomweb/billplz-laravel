<?php

namespace Billplz\Laravel\Tests\Feature;

use Billplz\Laravel\Billplz;
use Billplz\Laravel\BillplzServiceProvider;

it('has proper signature', function () {
    $billplz = new BillplzServiceProvider(null);

    $this->assertTrue($billplz->isDeferred());
    $this->assertSame(['billplz', 'Billplz\Client'], $billplz->provides());
});

it('provides the service', function () {
    config(['services.billplz.key' => 'abc']);

    $this->assertInstanceOf('Billplz\Client', $this->app->make('billplz'));
    $this->assertSame('https://www.billplz.com/api', Billplz::getApiEndpoint());
    $this->assertSame('abc', Billplz::getApiKey());
});

it('can configure api version', function () {
    config([
        'services.billplz.key' => 'abc',
        'services.billplz.version' => 'v4',
    ]);

    $this->assertSame('v4', Billplz::getApiVersion());
});

it('can use sandbox environment', function () {
    config([
        'services.billplz.key' => 'abc',
        'services.billplz.sandbox' => true,
    ]);

    $this->assertSame('https://www.billplz-sandbox.com/api', Billplz::getApiEndpoint());
});
