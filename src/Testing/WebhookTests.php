<?php

namespace Billplz\Laravel\Testing;

trait WebhookTests
{
    use Concerns\PreparesBillplz;

    /**
     * Make successful webhook.
     */
    protected function makeSuccessfulWebhook(string $uri)
    {
        $this->prepareConfiguration();

        $data = [
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
            'state' => 'paid',
            'amount' => '200',
            'paid_amount' => '200',
            'due_at' => '2020-12-31',
            'email' => 'api@billplz.com',
            'mobile' => '+60112223333',
            'name' => 'MICHAEL API',
            'url' => 'http://billplz.dev/bills/W_79pJDk',
            'paid_at' => '2015-03-09 16:23:59 +0800',
            'x_signature' => '6c52a7cd8212cbed06ed0022f6c148cf2ce8bca2e092391b73d76c19fb45e73f',
        ];

        return $this->post($uri, $data, ['Content-Type' => 'application/x-www-form-urlencoded'])
                    ->assertStatus(200);
    }

    /**
     * Make successful webhook without signature.
     */
    protected function makeSuccessfulWebhookWithoutSignature(string $uri)
    {
        $this->prepareConfigurationWithoutSignature();

        $data = [
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
            'state' => 'paid',
            'amount' => '200',
            'paid_amount' => '200',
            'due_at' => '2020-12-31',
            'email' => 'api@billplz.com',
            'mobile' => '+60112223333',
            'name' => 'MICHAEL API',
            'url' => 'http://billplz.dev/bills/W_79pJDk',
            'paid_at' => '2015-03-09 16:23:59 +0800',
        ];

        return $this->post($uri, $data, ['Content-Type' => 'application/x-www-form-urlencoded'])
                    ->assertStatus(200);
    }

    /**
     * Make unsuccessful webhook.
     */
    protected function makeUnsuccessfulWebhook(string $uri)
    {
        $data = [
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
        ];

        return $this->post($uri, $data, ['Content-Type' => 'application/x-www-form-urlencoded'])
                    ->assertStatus(422);
    }

    /**
     * Make unsuccessful webhook with invalid signature.
     */
    protected function makeUnsuccessfulWebhookWithInvalidSignature(string $uri)
    {
        $this->prepareConfiguration();

        $data = [
            'id' => 'W_79pJDk',
            'collection_id' => '599',
            'paid' => 'true',
            'state' => 'paid',
            'amount' => '200',
            'paid_amount' => '200',
            'due_at' => '2020-12-31',
            'email' => 'api@billplz.com',
            'mobile' => '+60112223333',
            'name' => 'MICHAEL API',
            'url' => 'http://billplz.dev/bills/W_79pJDk',
            'paid_at' => '2015-03-09 16:23:59 +0800',
            'x_signature' => '01bdc1167f8b4dd1f591d8af7ada00061d39ca2b63e66c6588474a918a04796c',
        ];

        return $this->post($uri, $data, ['Content-Type' => 'application/x-www-form-urlencoded'])
                    ->assertStatus(419);
    }
}
