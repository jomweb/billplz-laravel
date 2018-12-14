<?php

namespace Billplz\Laravel\Http\Requests;

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
        return [];
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

        if (is_null($validated)) {
            throw new HttpException(422, 'The given data was invalid.');
        }

        return $validated;
    }
}
