<?php

namespace Billplz\Laravel\Http\Requests;

use Billplz\Exceptions\FailedSignatureVerification;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Webhook extends PaymentCompletion
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'alpha_dash'],
            'collection_id' => ['required'],
            'amount' => ['required', 'numeric'],
            'state' => ['required', 'string'],
            'paid' => ['required', Rule::in(['true', 'false', true, false])],
            'paid_at' => ['nullable', 'date'],
            'paid_amount' => ['required', 'numeric'],
            'x_signature' => [$this->hasSignatureKey() ? 'required' : 'sometimes'],
            'transaction_id' => ['sometimes', 'nullable'],
            'transaction_status' => ['sometimes', 'nullable', Rule::in('pending', 'completed', 'failed')]
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @param  string|null  $key
     * @param  string|array|null  $default
     */
    public function validated($key = null, $default = null): array
    {
        try {
            $validated = $this->getResourceInstance()->webhook($this->post());
        } catch (FailedSignatureVerification $e) {
            throw new HttpException(419, 'Unable to verify X-Signature.', $e);
        }

        return $validated;
    }
}
