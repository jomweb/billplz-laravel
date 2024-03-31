<?php

namespace Billplz\Laravel\Tests\Feature\PaymentCompletion;

use Billplz\Laravel\Http\Requests\Webhook;
use Billplz\Laravel\Testing\WebhookTests;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;

use function Orchestra\Testbench\Pest\defineRoutes;

uses(WebhookTests::class);

defineRoutes(function (Router $router) {
    $router->post('webhook', function (Webhook $request) {
        return Arr::only($request->validated(), ['id', 'collection_id', 'paid', 'transaction_id', 'transaction_status']);
    });
});

it('can accept webhook callback', function () {
    $this->makeSuccessfulWebhook('webhook')
        ->assertJson([
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
        ]);

});

it('can accept webhook callback with extra payment info', function () {
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
});

it('can accept webhook callback when phone number is null', function () {
    $this->makeSuccessfulWebhook('webhook', ['mobile' => ''])
        ->assertJson([
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
        ]);
});

it('can accept webhook callback without signature', function () {
    $this->makeSuccessfulWebhookWithoutSignature('webhook')
        ->assertJson([
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
        ]);
});

it('cant accept webhook callback with invalid signature', function () {
    $this->makeUnsuccessfulWebhookWithInvalidSignature('webhook');
});

it('cant accept webhook callback given invalid data', function () {
    $this->makeUnsuccessfulWebhook('webhook');
});
