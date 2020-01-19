<?php

namespace Billplz\Laravel\Tests\Feature;

use Billplz\Laravel\Billplz;
use Billplz\Laravel\Tests\TestCase;
use Billplz\Laravel\BillplzServiceProvider;

class BillplzServiceProviderTest extends TestCase
{
    /** @test */
    public function it_has_proper_signature()
    {
        $billplz = new BillplzServiceProvider(null);

        $this->assertTrue($billplz->isDeferred());
        $this->assertSame(['billplz', 'Billplz\Client'], $billplz->provides());
    }

    /** @test */
    public function it_provides_the_service()
    {
        config(['services.billplz.key' => 'abc']);

        $this->assertInstanceOf('Billplz\Client', $this->app->make('billplz'));
        $this->assertSame('https://www.billplz.com/api', Billplz::getApiEndpoint());
        $this->assertSame('abc', Billplz::getApiKey());
    }

    /** @test */
    public function it_can_configure_api_version()
    {
        config([
            'services.billplz.key' => 'abc',
            'services.billplz.version' => 'v4',
        ]);

        $this->assertSame('v4', Billplz::getApiVersion());
    }

    /** @test */
    public function it_can_use_sandbox_environment()
    {
        config([
            'services.billplz.key' => 'abc',
            'services.billplz.sandbox' => true,
        ]);

        $this->assertSame('https://billplz-staging.herokuapp.com/api', Billplz::getApiEndpoint());
    }
}
