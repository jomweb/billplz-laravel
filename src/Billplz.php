<?php

namespace Billplz\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * @method \Billplz\Client useSandbox()
 * @method \Laravie\Codex\Contracts\Request uses(string $service, string|null $version = null)
 * @method \Laravie\Codex\Contracts\Request via(\Laravie\Codex\Contracts\Request $request)
 * @method \Billplz\Contracts\Collection collection(string|null $version = null)
 * @method \BIllplz\Contracts\OpenCollection openCollection(string|null $version = null)
 * @method \Billplz\Contracts\Bill bill(string|null $version = null)
 * @method \Billplz\Contracts\Bill\Transaction transaction(string|null $version = null)
 * @method \BIllplz\Contracts\Collection\MassPayment massPaymentCollection()
 * @method \Billplz\Contracts\MassPayment massPayment()
 * @method \Billplz\Contracts\BankAccount bank(string|null $version = null)
 *
 * @mixin \Billplz\Client
 */
class Billplz extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'billplz';
    }
}
