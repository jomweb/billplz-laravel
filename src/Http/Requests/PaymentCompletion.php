<?php

namespace Billplz\Laravel\Http\Requests;

use Billplz\Contracts\Bill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Billplz\Laravel\Exceptions\ValidationException;

abstract class PaymentCompletion extends FormRequest
{
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
     * Get resource instance.
     *
     * @return \Billplz\Contracts\Bill
     */
    public function getResourceInstance(): Bill
    {
        return $this->container->make('billplz')->bill();
    }
}
