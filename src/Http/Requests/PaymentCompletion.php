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
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @throws \Billplz\Laravel\Exceptions\ValidationException
     *
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator, null, $this->errorBag);
    }

    /**
     * Get client instance.
     *
     * @return \Billplz\Client
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
     *
     * @return \Billplz\Contracts\Bill
     */
    public function getResourceInstance(): Bill
    {
        return $this->getClientInstance()->bill();
    }

    /**
     * Check if Billplz if configured with signature.
     *
     * @return bool
     */
    protected function hasSignatureKey(): bool
    {
        return ! is_null($this->getClientInstance()->getSignatureKey());
    }
}
