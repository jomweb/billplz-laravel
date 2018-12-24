<?php

namespace Billplz\Laravel\Testing;

use Illuminate\Foundation\Testing\TestResponse;

trait RedirectionTests
{
    use Concerns\PreparesBillplz;

    /**
     * Make successful redirection.
     *
     * @param  string  $uri
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeSuccessfulRedirection(string $uri): TestResponse
    {
        $this->prepareConfiguration();

        $data = [
            'billplz' => [
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'paid_at' => '2015-03-09 16:23:59 +0800',
                'x_signature' => '3ea529e9897e7225cc443510c44077741b03eff448fd033d58ec5a6302c722e4',
            ],
        ];

        $query = http_build_query($data);

        return $this->get("{$uri}?{$query}")->assertStatus(200);
    }

    /**
     * Make successful redirection without x-signature.
     *
     * @param  string  $uri
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeSuccessfulRedirectionWithoutSignature(string $uri): TestResponse
    {
        $this->prepareConfigurationWithoutSignature();

        $data = [
            'billplz' => [
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'paid_at' => '2015-03-09 16:23:59 +0800',
            ],
        ];

        $query = http_build_query($data);

        return $this->get("{$uri}?{$query}")->assertStatus(200);
    }

    /**
     * Make unsuccessful redirection.
     *
     * @param  string  $uri
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeUnsuccessfulRedirection(string $uri): TestResponse
    {
        $this->prepareConfiguration();

        $data = [
            'billplz' => [
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'paid_at' => '2015-03-09 16:23:59 +0800',
            ],
        ];

        $query = http_build_query($data);

        return $this->get("{$uri}?{$query}")->assertStatus(422);
    }

    /**
     * Make unsuccessful redirection with invalid x-signature.
     *
     * @param  string  $uri
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeUnsuccessfulRedirectionWithInvalidSignature(string $uri): TestResponse
    {
        $this->prepareConfiguration();

        $data = [
            'billplz' => [
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'paid_at' => '2015-03-09 16:23:59 +0800',
                'x_signature' => '01bdc1167f8b4dd1f591d8af7ada00061d39ca2b63e66c6588474a918a04796c',
            ],
        ];

        $query = http_build_query($data);

        return $this->get("{$uri}?{$query}")->assertStatus(419);
    }
}
