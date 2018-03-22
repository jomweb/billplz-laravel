<?php

namespace Billplz\Laravel;

use Billplz\Client;
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

            $signature = isset($config['x-signature']) ? $config['x-signature'] : null;

            $billplz = Client::make($config['key'], $signature);

            if (isset($config['version'])) {
                $billplz->useVersion($config['version']);
            }

            if (isset($config['sandbox']) && $config['sandbox'] == true) {
                $billplz->useSandbox();
            }

            return $billplz;
        });
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
