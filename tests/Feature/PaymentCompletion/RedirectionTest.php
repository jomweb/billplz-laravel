<?php

namespace Billplz\Laravel\Tests\Feature\PaymentCompletion;

use Billplz\Laravel\Http\Requests\Redirection;
use Billplz\Laravel\Testing\RedirectionTests;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;

use function Orchestra\Testbench\Pest\defineRoutes;

uses(RedirectionTests::class);

defineRoutes(function (Router $router) {
    $router->get('completed', function (Redirection $request) {
        return Arr::only($request->validated(), ['id', 'paid', 'transaction_id', 'transaction_status']);
    });
});

it('can accept redirection callback', function () {
    $this->makeSuccessfulRedirection('completed')
        ->assertJson([
            'id' => 'W_79pJDk',
            'paid' => 'true',
        ]);
});

it('can accept redirection callback with extra payment info', function () {
    $this->makeSuccessfulRedirection('completed', [
        'transaction_id' => 'AC4GC031F42H',
        'transaction_status' => 'completed',
    ])
        ->assertJson([
            'id' => 'W_79pJDk',
            'paid' => 'true',
            'transaction_id' => 'AC4GC031F42H',
            'transaction_status' => 'completed',
        ]);
});

it('can accept redirection callback without signature', function () {
    $this->makeSuccessfulRedirectionWithoutSignature('completed')
        ->assertJson([
            'id' => 'W_79pJDk',
        ]);
});

it('cant accept redirection callback with invalid signature', function () {
    $this->makeUnsuccessfulRedirectionWithInvalidSignature('completed');
});

it('cant accept redirection callback given bad data', function () {
    $this->makeUnsuccessfulRedirection('completed');
});
