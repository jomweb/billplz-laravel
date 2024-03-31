<?php

namespace Billplz\Laravel\Tests\Feature\PaymentCompletion;

use Billplz\Laravel\Http\Requests\Webhook;
use Billplz\Laravel\Testing\WebhookTests;
use Billplz\Laravel\Tests\TestCase;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\Test;

class WebhookTest extends TestCase
{
    use WebhookTests;

    /** {@inheritDoc} */
    #[\Override]
    protected function defineRoutes($router): void
    {
        $router->post('webhook', function (Webhook $request) {
            return Arr::only($request->validated(), ['id', 'collection_id', 'paid', 'transaction_id', 'transaction_status']);
        });
    }

    #[Test]
    public function it_can_accept_webhook_callback()
    {
        $this->makeSuccessfulWebhook('webhook')
            ->assertJson([
                'id' => 'W_79pJDk',
                'collection_id' => '599',
                'paid' => 'true',
            ]);
    }

    #[Test]
    public function it_can_accept_webhook_callback_with_extra_payment_info()
    {
        $this->makeSuccessfulWebhook('webhook', [
            'transaction_id' => 'AC4GC031F42H',
            'transaction_status' => 'completed',
        ])->assertJson([
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
            'transaction_id' => 'AC4GC031F42H',
            'transaction_status' => 'completed',
        ]);
    }

    #[Test]
    public function it_can_accept_webhook_callback_when_phone_number_is_null()
    {
        $this->makeSuccessfulWebhook('webhook', ['mobile' => ''])
            ->assertJson([
                'id' => 'W_79pJDk',
                'collection_id' => '599',
                'paid' => 'true',
            ]);
    }

    #[Test]
    public function it_can_accept_webhook_callback_without_signature()
    {
        $this->makeSuccessfulWebhookWithoutSignature('webhook')
            ->assertJson([
                'id' => 'W_79pJDk',
                'collection_id' => '599',
                'paid' => 'true',
            ]);
    }

    #[Test]
    public function it_cant_accept_webhook_callback_with_invalid_signature()
    {
        $this->makeUnsuccessfulWebhookWithInvalidSignature('webhook');
    }

    #[Test]
    public function it_cant_accept_webhook_callback_given_invalid_data()
    {
        $this->makeUnsuccessfulWebhook('webhook');
    }
}
