<?php

namespace Billplz\Laravel\Testing;

use Billplz\Signature;

trait WebhookTests
{
    use Concerns\PreparesBillplz;

    /**
     * Make successful webhook.
     *
     * @return \Illuminate\Testing\TestResponse
     */
    protected function makeSuccessfulWebhook(string $uri, array $payload = [])
    {
        $this->prepareConfiguration();

        $data = \array_merge([
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
        ], $payload);

        $signature = new Signature(\config('services.billplz.x-signature'), Signature::WEBHOOK_PARAMETERS);

        $data['x_signature'] = $signature->create($data);

        return $this->post($uri, $data, ['Content-Type' => 'application/x-www-form-urlencoded'])
            ->assertStatus(200);
    }

    /**
     * Make successful webhook without signature.
     *
     * @return \Illuminate\Testing\TestResponse
     */
    protected function makeSuccessfulWebhookWithoutSignature(string $uri, array $payload = [])
    {
        $this->prepareConfigurationWithoutSignature();

        $data = \array_merge([
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
        ], $payload);

        return $this->post($uri, $data, ['Content-Type' => 'application/x-www-form-urlencoded'])
            ->assertStatus(200);
    }

    /**
     * Make unsuccessful webhook.
     *
     * @return \Illuminate\Testing\TestResponse
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
     *
     * @return \Illuminate\Testing\TestResponse
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
