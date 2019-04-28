<?php

namespace Billplz\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * @method \Billplz\Client useSandbox()
 * @method \Billplz\Contracts\Collection collection(string|null $version = null)
 * @method \BIllplz\Contracts\OpenCollection openCollection(string|null $version = null)
 * @method \Billplz\Contracts\Bill bill(string|null $version = null)
 * @method \Billplz\Contracts\Bill\Transaction transaction(string|null $version = null)
 * @method \BIllplz\Contracts\Collection\MassPayment massPaymentCollection()
 * @method \Billplz\Contracts\MassPayment massPayment()
 * @method \Billplz\Contracts\BankAccount bank(string|null $version = null)
 *
 * @see \Billplz\Client
 */
class Billplz extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'billplz';
    }
}
