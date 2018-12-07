<?php

namespace Billplz\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class PaymentCompletion extends FormRequest
{
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
