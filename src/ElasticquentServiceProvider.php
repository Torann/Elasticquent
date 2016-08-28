<?php

namespace Elasticquent;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticquentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->isLumen() === false) {
            $this->publishes([
                __DIR__.'/../config/elasticquent.php' => config_path('elasticquent.php'),
            ]);

            $this->mergeConfigFrom(
                __DIR__.'/../config/elasticquent.php', 'elasticquent'
            );
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            return ClientBuilder::fromConfig($app->config->get('elasticquent.config'));
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Map::class,
                Console\Index::class,
                Console\Install::class,
                Console\Uninstall::class,
            ]);
        }
    }

    /**
     * Check if package is running under a Lumen app.
     *
     * @return bool
     */
    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen') === true;
    }
}
