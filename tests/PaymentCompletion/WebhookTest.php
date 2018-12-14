<?php

namespace Billplz\Laravel\TestCase\PaymentCompletion;

use Illuminate\Support\Arr;
use Billplz\Laravel\TestCase\TestCase;
use Billplz\Laravel\Http\Requests\Webhook;

class WebhookTest extends TestCase
{
    /** @test */
    public function it_can_accept_webhook_callback()
    {
        $router = $this->app['router'];

        $router->post('webhook', function (Webhook $request) {
            return Arr::only($request->validated(), ['id', 'collection_id', 'paid']);
        });

        $this->post('webhook', [
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
            'state' => 'paid',
            'amount' => '200',
            'paid_amount' => '0',
            'due_at' => '2020-12-31',
            'email' => 'api@billplz.com',
            'mobile' => '+60112223333',
            'name' => 'MICHAEL API',
            'url' => 'http://billplz.dev/bills/W_79pJDk',
            'paid_at' => '2015-03-09 16:23:59 +0800',
            'x_signature' => 'b783a0c8e46c5c85a7a8daf3c39d39ebb1fc12c6941f91b4bc41f161fc94575e',
        ], ['Content-Type' => 'application/x-www-form-urlencoded'])
        ->assertStatus(200)
        ->assertJson([
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
        ]);
    }

    /** @test */
    public function it_can_accept_webhook_callback_without_signature()
    {
        $this->app['config']->set(['services.billplz.x-signature' => null]);

        $router = $this->app['router'];

        $router->post('webhook', function (Webhook $request) {
            return Arr::only($request->validated(), ['id', 'collection_id', 'paid']);
        });

        $this->post('webhook', [
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
            'state' => 'paid',
            'amount' => '200',
            'paid_amount' => '0',
            'due_at' => '2020-12-31',
            'email' => 'api@billplz.com',
            'mobile' => '+60112223333',
            'name' => 'MICHAEL API',
            'url' => 'http://billplz.dev/bills/W_79pJDk',
            'paid_at' => '2015-03-09 16:23:59 +0800',
        ], ['Content-Type' => 'application/x-www-form-urlencoded'])
        ->assertStatus(200)
        ->assertJson([
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
        ]);
    }

    /**
     * @test
     */
    public function it_cant_accept_webhook_callback_with_invalid_signature()
    {
        $router = $this->app['router'];

        $router->post('webhook', function (Webhook $request) {
            return $request->validated();
        });

        $this->post('webhook', [
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
            'state' => 'paid',
            'amount' => '200',
            'paid_amount' => '0',
            'due_at' => '2020-12-31',
            'email' => 'api@billplz.com',
            'mobile' => '+60112223333',
            'name' => 'MICHAEL API',
            'url' => 'http://billplz.dev/bills/W_79pJDk',
            'paid_at' => '2015-03-09 16:23:59 +0800',
            'x_signature' => '01bdc1167f8b4dd1f591d8af7ada00061d39ca2b63e66c6588474a918a04796c',
        ], ['Content-Type' => 'application/x-www-form-urlencoded'])
        ->assertStatus(419);
    }
}
