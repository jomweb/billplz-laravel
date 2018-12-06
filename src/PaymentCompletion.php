<?php

namespace Billplz\Laravel;

use Illuminate\Http\Request;
use Laravie\Codex\Contracts\Response;

class PaymentCompletion
{
    /**
     * Retrieve redirect message.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|null
     */
    public static function redirect(Request $request): ?array
    {
        return resolve('billplz')->bill()->redirect($request->query());
    }

    /**
     * Retrieve webhook message.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|null
     */
    public static function webhook(Request $request): ?array
    {
        return resolve('billplz')->bill()->webhook($request->post());
    }
}
