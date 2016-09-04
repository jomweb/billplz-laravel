<?php

namespace Billplz\Illuminate;

use Billplz\Client;
use Illuminate\Support\ServiceProvider;
use Http\Client\Common\HttpMethodsClient;
use Illuminate\Contracts\Foundation\Application;
use Http\Adapter\Guzzle6\Client as GuzzleHttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;

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

            $billplz = new Client($this->getHttpClient(), $config['key']);

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
     * Set HTTP client.
     *
     * @return \Http\Client\Common\HttpMethodsClient
     */
    protected function getHttpClient()
    {
        return new HttpMethodsClient(
                new GuzzleHttpClient(),
                new GuzzleMessageFactory()
            );
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
