<?php

namespace Billplz\Laravel;

use Billplz\Client;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Laravie\Codex\Discovery;

class BillplzServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('billplz', function (Container $app) {
            $config = $app->make('config')->get('services.billplz');

            return $this->createBillplzClient($config);
        });

        $this->app->alias('billplz', Client::class);
    }

    /**
     * Create Billplz Client.
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
