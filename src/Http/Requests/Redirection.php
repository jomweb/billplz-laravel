<?php

namespace Billplz\Laravel\Http\Requests;

class Redirection extends PaymentCompletion
{
    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated(): array
    {
        if (is_null($validated = $this->getResourceInstance()->redirect($this->query()))) {
            throw new InvalidResponseException();
        }

        return $validated;
    }
}
