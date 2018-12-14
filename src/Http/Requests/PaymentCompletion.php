<?php

namespace Billplz\Laravel\Http\Requests;

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
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, null, $this->errorBag);
    }

    /**
     * Get resource instance.
     *
     * @return \Billplz\Base\Bill
     */
    public function getResourceInstance()
    {
        return $this->container->make('billplz')->bill();
    }
}
