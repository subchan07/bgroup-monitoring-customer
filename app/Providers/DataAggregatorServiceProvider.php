<?php

namespace App\Providers;

use App\Services\DataAggregatorService;
use App\Services\Impl\DataAggregatorServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DataAggregatorServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        DataAggregatorService::class => DataAggregatorServiceImpl::class
    ];

    public function provides()
    {
        return [DataAggregatorService::class];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
