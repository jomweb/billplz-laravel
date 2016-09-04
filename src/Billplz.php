<?php

namespace Billplz\Illuminate;

use Illuminate\Support\Facades\Facade;

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
