<?php

namespace App\Providers;

use App\Services\UrlSortener\URLShortener;
use App\Services\UrlSortener\UrlShortenerManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(URLShortener::class, UrlShortenerManager::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
