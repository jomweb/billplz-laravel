<?php

namespace Billplz\Laravel\Testing\Concerns;

trait PreparesBillplz
{
    /**
     * Prepare configuration.
     *
     * @return void
     */
    protected function prepareConfiguration(): void
    {
        $this->app['config']->set('services.billplz', [
            'key' => '73eb57f0-7d4e-42b9-a544-aeac6e4b0f81',
            'version' => 'v4',
            'x-signature' => 'secret',
            'sandbox' => false,
        ]);
    }

    /**
     * Prepare configuration without signature.
     *
     * @return void
     */
    protected function prepareConfigurationWithoutSignature(): void
    {
        $this->app['config']->set('services.billplz', [
            'key' => '73eb57f0-7d4e-42b9-a544-aeac6e4b0f81',
            'version' => 'v4',
            'x-signature' => null,
            'sandbox' => false,
        ]);
    }
}
