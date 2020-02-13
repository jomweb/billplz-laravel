<?php

namespace Billplz\Laravel\Http\Requests;

use Billplz\Client;
use Billplz\Contracts\Bill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Billplz\Laravel\Exceptions\ValidationException;

abstract class PaymentCompletion extends FormRequest
{
    /**
     * The client instance.
     *
     * @var \Billplz\Client
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
            $this->billplzClient = $this->container->make('billplz');
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
        return ! is_null($this->getClientInstance()->getSignatureKey());
    }
}
