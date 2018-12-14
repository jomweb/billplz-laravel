<?php

namespace Billplz\Laravel\Http\Requests;

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
            $validated = $this->getResourceInstance()->webhook($this->post());

            return $validated ?? [];
        } catch (FailedSignatureVerification $e) {
            throw new HttpException(419, 'Unable to verify X-Signature.', $e);
        }
    }
}
