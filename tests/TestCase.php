<?php

namespace Billplz\Laravel\Tests;

use Orchestra\Testbench\TestCase as Testbench;

abstract class TestCase extends Testbench
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('services.billplz', [
            'key' => '73eb57f0-7d4e-42b9-a544-aeac6e4b0f81',
            'version' => 'v4',
            'x-signature' => 'secret',
            'sandbox' => false,
        ]);
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Billplz' => \Billplz\Laravel\Billplz::class,
        ];
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Billplz\Laravel\BillplzServiceProvider::class,
        ];
    }
}
