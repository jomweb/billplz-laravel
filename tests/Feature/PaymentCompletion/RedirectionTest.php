<?php

namespace Billplz\Laravel\Tests\Feature\PaymentCompletion;

use Billplz\Laravel\Http\Requests\Redirection;
use Billplz\Laravel\Testing\RedirectionTests;
use Billplz\Laravel\Tests\TestCase;
use Illuminate\Support\Arr;

class RedirectionTest extends TestCase
{
    use RedirectionTests;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['router']->get('completed', function (Redirection $request) {
            return Arr::only($request->validated(), ['id', 'paid', 'transaction_id', 'transaction_status']);
        });
    }

    /** @test */
    public function it_can_accept_redirection_callback()
    {
        $this->makeSuccessfulRedirection('completed')
            ->assertJson([
                'id' => 'W_79pJDk',
                'paid' => 'true',
            ]);
    }

    /** @test */
    public function it_can_accept_redirection_callback_with_extra_payment_info()
    {
        $this->makeSuccessfulRedirection('completed', [
            'transaction_id' => 'AC4GC031F42H',
            'transaction_status' =>  'completed',
        ])
            ->assertJson([
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'transaction_id' => 'AC4GC031F42H',
                'transaction_status' => 'completed'
            ]);
    }

    /** @test */
    public function it_can_accept_redirection_callback_without_signature()
    {
        $this->makeSuccessfulRedirectionWithoutSignature('completed')
            ->assertJson([
                'id' => 'W_79pJDk',
            ]);
    }

    /** @test */
    public function it_cant_accept_redirection_callback_with_invalid_signature()
    {
        $this->makeUnsuccessfulRedirectionWithInvalidSignature('completed');
    }

    /** @test */
    public function it_cant_accept_redirection_callback_given_bad_data()
    {
        $this->makeUnsuccessfulRedirection('completed');
    }
}
