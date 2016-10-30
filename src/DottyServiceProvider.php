<?php

namespace Lingxi\Dotty;

use Lingxi\Dotty\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class DottyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $source = realpath(__DIR__.'/../config/dotty.php');

        $this->publishes([$source => config_path('dotty.php')]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/dotty.php', 'dotty'
        );

        $this->rebindUrlGenerator();
    }

    public function rebindUrlGenerator()
    {
        if ($this->app['config']->get('dotty.open')) {
            $this->app->singleton('url', function ($app) {
                $routes = $app['router']->getRoutes();

                // The URL generator needs the route collection that exists on the router.
                // Keep in mind this is an object, so we're passing by references here
                // and all the registered routes will be available to the generator.
                $app->instance('routes', $routes);

                $url = new UrlGenerator(
                    $routes, $app->rebinding(
                        'request', $this->requestRebinder()
                    )
                );

                $url->setSessionResolver(function () {
                    return $this->app['session'];
                });

                // If the route collection is "rebound", for example, when the routes stay
                // cached for the application, we will need to rebind the routes on the
                // URL generator instance so it has the latest version of the routes.
                $app->rebinding('routes', function ($app, $routes) {
                    $app['url']->setRoutes($routes);
                });

                return $url;
            });
        }
    }

    protected function requestRebinder()
    {
        return function ($app, $request) {
            $app['url']->setRequest($request);
        };
    }
}
