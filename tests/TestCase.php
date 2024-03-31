<?php

namespace Billplz\Laravel\Tests;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Testbench;

abstract class TestCase extends Testbench
{
    use WithWorkbench;

    /** {@inheritDoc} */
    #[\Override]
    protected function defineEnvironment($app): void
    {
        $app['config']->set('services.billplz', [
            'key' => '73eb57f0-7d4e-42b9-a544-aeac6e4b0f81',
            'version' => 'v4',
            'x-signature' => 'secret',
            'sandbox' => false,
        ]);
    }

    /** {@inheritDoc} */
    #[\Override]
    protected function getPackageAliases($app): array
    {
        return [
            'Billplz' => \Billplz\Laravel\Billplz::class,
        ];
    }
}
