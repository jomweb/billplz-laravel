<?php

namespace Billplz\Laravel;

use Billplz\Client;
use Laravie\Codex\Discovery;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;

class BillplzServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('billplz', function (Application $app) {
            $config = $app->make('config')->get('services.billplz');

            return $this->createBillplzClient($config);
        });

        $this->app->alias('billplz', Client::class);
    }

    /**
     * Create Billplz Client.
     *
     * @param  array  $config
     *
     * @return \Billplz\Client
     */
    protected function createBillplzClient(array $config)
    {
        $signature = $config['x-signature'] ?? null;
        $sandbox = $config['sandbox'] ?? false;

        $billplz = new Client($this->createHttpClient(), $config['key'], $signature);

        $billplz->useVersion($config['version'] ?? 'v4');

        if ($sandbox == true) {
            $billplz->useSandbox();
        }

        return $billplz;
    }

    /**
     * Create HTTP Client.
     *
     * @return \Http\Client\Common\HttpMethodsClient
     */
    protected function createHttpClient()
    {
        return Discovery::client();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'billplz',
            Client::class,
        ];
    }
}
