<?php

namespace Billplz\Laravel\Tests\PaymentCompletion;

use Illuminate\Support\Arr;
use Billplz\Laravel\Tests\TestCase;
use Billplz\Laravel\Testing\WebhookTests;
use Billplz\Laravel\Http\Requests\Webhook;

class WebhookTest extends TestCase
{
    use WebhookTests;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['router']->post('webhook', function (Webhook $request) {
            return Arr::only($request->validated(), ['id', 'collection_id', 'paid']);
        });
    }

    /** @test */
    public function it_can_accept_webhook_callback()
    {
        $this->makeSuccessfulWebhook('webhook')
            ->assertJson([
                'id' => 'W_79pJDk',
                'collection_id' => '599',
                'paid' => 'true',
            ]);
    }

    /** @test */
    public function it_can_accept_webhook_callback_without_signature()
    {
        $this->makeSuccessfulWebhookWithoutSignature('webhook')
            ->assertJson([
                'id' => 'W_79pJDk',
                'collection_id' => '599',
                'paid' => 'true',
            ]);
    }

    /** @test */
    public function it_cant_accept_webhook_callback_with_invalid_signature()
    {
        $this->makeUnsuccessfulWebhookWithInvalidSignature('webhook');
    }

    /** @test */
    public function it_cant_accept_webhook_callback_given_invalid_data()
    {
        $this->makeUnsuccessfulWebhook('webhook');
    }
}
