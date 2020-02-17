<?php

namespace Billplz\Laravel\Http\Requests;

use Illuminate\Validation\Rule;
use Billplz\Exceptions\FailedSignatureVerification;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Webhook extends PaymentCompletion
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'alpha_dash'],
            'collection_id' => ['required'],
            'amount' => ['required', 'numeric'],
            'state' => ['required', 'string'],
            'paid' => ['required', Rule::in(['true', 'false', true, false])],
            'paid_at' => ['required', 'date'],
            'paid_amount' => ['required', 'numeric'],
            'x_signature' => [$this->hasSignatureKey() ? 'required' : 'sometimes'],
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated(): array
    {
        try {
            $validated = $this->getResourceInstance()->webhook($this->post());
        } catch (FailedSignatureVerification $e) {
            throw new HttpException(419, 'Unable to verify X-Signature.', $e);
        }

        return $validated;
    }
}
