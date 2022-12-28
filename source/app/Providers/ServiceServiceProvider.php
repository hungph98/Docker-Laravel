<?php

namespace App\Providers;

use App\Services\Contracts\FileServiceInterface;
use App\Services\Contracts\ExamplesServiceInterface;
use App\Services\Api\ExamplesService;
use App\Services\Production\FileService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected $services = [
        FileServiceInterface::class => FileService::class,
        ExamplesServiceInterface::class => ExamplesService::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->services as $interface => $class) {
            $this->app->singleton($interface, $class);
        }
    }
}
