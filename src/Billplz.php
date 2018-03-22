<?php

namespace Billplz\Laravel;

use Illuminate\Support\Facades\Facade;

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
