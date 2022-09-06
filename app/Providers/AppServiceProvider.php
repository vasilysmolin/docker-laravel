<?php

namespace App\Providers;

use App\Objects\ApiUsersParserInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use VK\Client\VKApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ApiUsersParserInterface::class, VKApiClient::class);
        URL::forceScheme('https');
    }
}
