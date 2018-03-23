<?php

namespace Billplz\Laravel;

use Billplz\Client;
use Laravie\Codex\Discovery;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class BillplzServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

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
        $signature = isset($config['x-signature']) ? $config['x-signature'] : null;

        $billplz = new Client($this->createHttpClient(), $config['key'], $signature);

        if (isset($config['version'])) {
            $billplz->useVersion($config['version']);
        }

        if (isset($config['sandbox']) && $config['sandbox'] == true) {
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
        return ['billplz'];
    }
}
