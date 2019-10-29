<?php

namespace App\Store\Providers;
use App\Store\Analysis\AnalysisRepository;
use App\Store\Contracts\Repository\Analysis;
use App\Store\Contracts\Services\AnalysisService;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Analysis::class, AnalysisRepository::class);
        $this->app->bind(AnalysisService::class, \App\Store\Analysis\AnalysisService::class);
    }
}
