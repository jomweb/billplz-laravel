<?php

namespace Billplz\Laravel\Http\Requests;

use Billplz\Client;
use Billplz\Contracts\Bill;
use Billplz\Laravel\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class PaymentCompletion extends FormRequest
{
    /**
     * The client instance.
     *
     * @var \Billplz\Client|null
     */
    protected $billplzClient;

    /**
     * Handle a failed validation attempt.
     *
     * @throws \Billplz\Laravel\Exceptions\ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator, null, $this->errorBag);
    }

    /**
     * Get client instance.
     */
    public function getClientInstance(): Client
    {
        if (! isset($this->billplzClient)) {
            /** @var \Billplz\Client $client */
            $client = $this->container->make('billplz');

            $this->billplzClient = $client;
        }

        return $this->billplzClient;
    }

    /**
     * Get resource instance.
     */
    public function getResourceInstance(): Bill
    {
        return $this->getClientInstance()->bill();
    }

    /**
     * Check if Billplz if configured with signature.
     */
    protected function hasSignatureKey(): bool
    {
        return ! \is_null($this->getClientInstance()->getSignatureKey());
    }
}
