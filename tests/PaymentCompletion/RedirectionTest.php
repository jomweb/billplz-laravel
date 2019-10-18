<?php

namespace Billplz\Laravel\Tests\PaymentCompletion;

use Illuminate\Support\Arr;
use Billplz\Laravel\Tests\TestCase;
use Billplz\Laravel\Testing\RedirectionTests;
use Billplz\Laravel\Http\Requests\Redirection;

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
            return Arr::only($request->validated(), ['id', 'paid']);
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
