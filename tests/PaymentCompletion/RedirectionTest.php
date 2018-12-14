<?php

namespace Billplz\Laravel\TestCase\PaymentCompletion;

use Illuminate\Support\Arr;
use Billplz\Laravel\TestCase\TestCase;
use Billplz\Laravel\Http\Requests\Redirection;

class RedirectionTest extends TestCase
{
    /** @test */
    public function it_can_accept_redirection_callback()
    {
        $router = $this->app['router'];

        $router->get('completed', function (Redirection $request) {
            return Arr::only($request->validated(), ['id', 'paid']);
        });

        $bill = [
            'billplz' => [
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'paid_at' => '2015-03-09 16:23:59 +0800',
                'x_signature' => '3ea529e9897e7225cc443510c44077741b03eff448fd033d58ec5a6302c722e4',
            ],
        ];

        $this->get('completed?'.http_build_query($bill))
            ->assertStatus(200)
            ->assertJson([
                'id' => 'W_79pJDk',
                'paid' => 'true',
            ]);
    }

    /** @test */
    public function it_can_accept_redirection_callback_without_signature()
    {
        $this->app['config']->set(['services.billplz.x-signature' => null]);

        $router = $this->app['router'];

        $router->get('completed', function (Redirection $request) {
            return Arr::only($request->validated(), ['id', 'paid']);
        });

        $bill = [
            'billplz' => [
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'paid_at' => '2015-03-09 16:23:59 +0800',
            ],
        ];

        $this->get('completed?'.http_build_query($bill))
            ->assertStatus(200)
            ->assertJson([
                'id' => 'W_79pJDk',
                'paid' => 'true',
            ]);
    }

    /**
     * @test
     */
    public function it_cant_accept_redirection_callback_with_invalid_signature()
    {
        $router = $this->app['router'];

        $router->get('completed', function (Redirection $request) {
            return $request->validated();
        });

        $bill = [
            'billplz' => [
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'paid_at' => '2015-03-09 16:23:59 +0800',
                'x_signature' => '01bdc1167f8b4dd1f591d8af7ada00061d39ca2b63e66c6588474a918a04796c',
            ],
        ];

        $this->get('completed?'.http_build_query($bill))
            ->assertStatus(419);
    }
}
