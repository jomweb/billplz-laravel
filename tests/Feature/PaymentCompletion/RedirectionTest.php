<?php

namespace Billplz\Laravel\Tests\Feature\PaymentCompletion;

use Billplz\Laravel\Http\Requests\Redirection;
use Billplz\Laravel\Testing\RedirectionTests;
use Billplz\Laravel\Tests\TestCase;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\Test;

class RedirectionTest extends TestCase
{
    use RedirectionTests;

    /** {@inheritDoc} */
    #[\Override]
    protected function defineRoutes($router): void
    {
        $router->get('completed', function (Redirection $request) {
            return Arr::only($request->validated(), ['id', 'paid', 'transaction_id', 'transaction_status']);
        });
    }

    #[Test]
    public function it_can_accept_redirection_callback()
    {
        $this->makeSuccessfulRedirection('completed')
            ->assertJson([
                'id' => 'W_79pJDk',
                'paid' => 'true',
            ]);
    }

    #[Test]
    public function it_can_accept_redirection_callback_with_extra_payment_info()
    {
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
    }

    #[Test]
    public function it_can_accept_redirection_callback_without_signature()
    {
        $this->makeSuccessfulRedirectionWithoutSignature('completed')
            ->assertJson([
                'id' => 'W_79pJDk',
            ]);
    }

    #[Test]
    public function it_cant_accept_redirection_callback_with_invalid_signature()
    {
        $this->makeUnsuccessfulRedirectionWithInvalidSignature('completed');
    }

    #[Test]
    public function it_cant_accept_redirection_callback_given_bad_data()
    {
        $this->makeUnsuccessfulRedirection('completed');
    }
}
