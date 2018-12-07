<?php

namespace Billplz\Laravel\Http\Requests;

class Webhook extends PaymentCompletion
{
    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated(): array
    {
        if (is_null($validated = $this->getResourceInstance()->webhook($this->post()))) {
            throw new InvalidResponseException();
        }

        return $validated;
    }
}
