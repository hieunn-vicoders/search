<?php

namespace VCComponent\Laravel\Search\Providers;

use Illuminate\Support\ServiceProvider;
use VCComponent\Laravel\Search\Services\Search;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any package services
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("search", Search::class);
    }
}
