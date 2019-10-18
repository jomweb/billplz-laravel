<?php

namespace Billplz\Laravel\Http\Requests;

use Illuminate\Validation\Rule;
use Billplz\Exceptions\FailedSignatureVerification;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Redirection extends PaymentCompletion
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'billplz.id' => ['required', 'alpha_dash'],
        ];

        if ($this->hasSignatureKey()) {
            $rules['billplz.paid'] = ['required', Rule::in(['true', 'false', true, false])];
            $rules['billplz.paid_at'] = ['required', 'date'];
            $rules['billplz.x_signature'] = [$this->hasSignatureKey() ? 'required' : 'sometimes'];
        }

        return $rules;
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated(): array
    {
        try {
            $validated = $this->getResourceInstance()->redirect($this->query());
        } catch (FailedSignatureVerification $e) {
            throw new HttpException(419, 'Unable to verify X-Signature.', $e);
        }

        return $validated;
    }
}
