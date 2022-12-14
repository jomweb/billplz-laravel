<?php

namespace Billplz\Laravel\Http\Requests;

use Billplz\Exceptions\FailedSignatureVerification;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Redirection extends PaymentCompletion
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $rules = [
            'billplz.id' => ['required', 'alpha_dash'],
        ];

        if ($this->hasSignatureKey()) {
            $rules['billplz.paid'] = ['required', Rule::in(['true', 'false', true, false])];
            $rules['billplz.paid_at'] = ['nullable', 'date'];
            $rules['billplz.x_signature'] = ['required'];
            $rules['billplz.transaction_id'] = ['sometimes', 'nullable'];
            $rules['billplz.transaction_status'] = ['sometimes', 'nullable', Rule::in('pending', 'completed', 'failed')];
        }

        return $rules;
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
            $validated = $this->getResourceInstance()->redirect($this->query());
        } catch (FailedSignatureVerification $e) {
            throw new HttpException(419, 'Unable to verify X-Signature.', $e);
        }

        return $validated;
    }
}
