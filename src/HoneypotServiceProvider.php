<?php

declare(strict_types=1);

namespace Devlop\Honeypot;

use Devlop\Honeypot\HoneypotComponent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class HoneypotServiceProvider extends ServiceProvider
{
    /**
     * Get the services provided by the provider.
     *
     * @return array<class-string>
     */
    public function provides() : array
    {
        return [
            HoneypotServiceInterface::class,
        ];
    }

    /**
     * Register the service provider.
     */
    public function register() : void
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'honeypot');

        $this->app->singleton(HoneypotServiceInterface::class, function (Application $app) : HoneypotServiceInterface {
            $config = $this->app['config']->get('honeypot');

            $name = $config['input-name'] ?? $this->generateInputName($this->app['config']->get('app.name'));

            return new HoneypotService($name);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'honeypot');

        $this->publishes(
            [
                $this->getConfigPath() => config_path('honeypot.php'),
            ],
            'config'
        );

        $config = $this->app['config']->get('honeypot');

        Blade::components([
            HoneypotComponent::class => $config['component-name'],
        ]);
    }

    /**
     * Get the honeypot config path
     */
    private function getConfigPath() : string
    {
        return __DIR__ . '/../config/honeypot.php';
    }

    /**
     * Generate the input name from the application name
     */
    private function generateInputName(string $applicationName) : string
    {
        return 'email-' . md5($applicationName);
    }
}
