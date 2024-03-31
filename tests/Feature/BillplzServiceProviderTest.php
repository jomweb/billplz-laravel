<?php

namespace Billplz\Laravel\Tests\Feature;

use Billplz\Laravel\Billplz;
use Billplz\Laravel\BillplzServiceProvider;
use Billplz\Laravel\Tests\TestCase;

class BillplzServiceProviderTest extends TestCase
{
    #[Test]
    public function it_has_proper_signature()
    {
        $billplz = new BillplzServiceProvider(null);

        $this->assertTrue($billplz->isDeferred());
        $this->assertSame(['billplz', 'Billplz\Client'], $billplz->provides());
    }

    #[Test]
    public function it_provides_the_service()
    {
        config(['services.billplz.key' => 'abc']);

        $this->assertInstanceOf('Billplz\Client', $this->app->make('billplz'));
        $this->assertSame('https://www.billplz.com/api', Billplz::getApiEndpoint());
        $this->assertSame('abc', Billplz::getApiKey());
    }

    #[Test]
    public function it_can_configure_api_version()
    {
        config([
            'services.billplz.key' => 'abc',
            'services.billplz.version' => 'v4',
        ]);

        $this->assertSame('v4', Billplz::getApiVersion());
    }

    #[Test]
    public function it_can_use_sandbox_environment()
    {
        config([
            'services.billplz.key' => 'abc',
            'services.billplz.sandbox' => true,
        ]);

        $this->assertSame('https://www.billplz-sandbox.com/api', Billplz::getApiEndpoint());
    }
}
