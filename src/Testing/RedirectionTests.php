<?php

namespace Billplz\Laravel\Testing;

trait RedirectionTests
{
    use Concerns\PreparesBillplz;

    /**
     * Make successful redirection.
     */
    protected function makeSuccessfulRedirection(string $uri)
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

        $query = \http_build_query($data);

        return $this->get("{$uri}?{$query}")->assertStatus(200);
    }

    /**
     * Make successful redirection without x-signature.
     */
    protected function makeSuccessfulRedirectionWithoutSignature(string $uri)
    {
        $this->prepareConfigurationWithoutSignature();

        $data = [
            'billplz' => [
                'id' => 'W_79pJDk',
            ],
        ];

        $query = \http_build_query($data);

        return $this->get("{$uri}?{$query}")->assertStatus(200);
    }

    /**
     * Make unsuccessful redirection.
     */
    protected function makeUnsuccessfulRedirection(string $uri)
    {
        $this->prepareConfiguration();

        $data = [
            'billplz' => [
                'id' => 'W_79pJDk',
                'paid' => 'true',
                'paid_at' => '2015-03-09 16:23:59 +0800',
            ],
        ];

        $query = \http_build_query($data);

        return $this->get("{$uri}?{$query}")->assertStatus(422);
    }

    /**
     * Make unsuccessful redirection with invalid x-signature.
     */
    protected function makeUnsuccessfulRedirectionWithInvalidSignature(string $uri)
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

        $query = \http_build_query($data);

        return $this->get("{$uri}?{$query}")->assertStatus(419);
    }
}
