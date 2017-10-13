<?php

namespace Corcel\Laravel;

use Auth;
use Corcel\Laravel\Auth\AuthUserProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class CorcelServiceProvider
 *
 * @package Corcel\Providers\Laravel
 * @author Mickael Burguet <www.rundef.com>
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CorcelServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishConfigFile();
        $this->registerAuthProvider();
        $this->registerRoutes();
    }
    
    /**
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @return void
     */
    private function publishConfigFile()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('corcel.php'),
        ]);
    }

    /**
     * @return void
     */
    private function registerAuthProvider()
    {
        Auth::provider('corcel', function ($app, array $config) {
            return new AuthUserProvider($config);
        });
    }

    /**
     * @return void
     */
    private function registerRoutes()
    {
        $router = $this->app->make('router');

        $router->group([
            'namespace' => 'Corcel\Laravel\Controllers',
            'prefix' => 'api',
        ], function ($router) {
            require __DIR__ . '/routes.php';
        });
    }
}
