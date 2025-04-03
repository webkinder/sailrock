<?php

namespace Webkinder\Sailrock;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Webkinder\Sailrock\Console\AddCommand;
use Webkinder\Sailrock\Console\InstallCommand;
use Webkinder\Sailrock\Console\PublishCommand;

class SailrockServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->configurePublishing();
    }

    /**
     * Register the console commands for the package.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                AddCommand::class,
                PublishCommand::class,
            ]);
        }
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../runtimes' => $this->app->basePath('../../../../docker'),
            ], ['sailrock', 'sailrock-docker']);

            $this->publishes([
                __DIR__ . '/../bin/sailrock' => $this->app->basePath('../../../../sailrock'),
            ], ['sailrock', 'sailrock-bin']);

            $this->publishes([
                __DIR__ . '/../database' => $this->app->basePath('../../../../docker'),
            ], ['sailrock', 'sailrock-database']);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            InstallCommand::class,
            PublishCommand::class,
        ];
    }
}
