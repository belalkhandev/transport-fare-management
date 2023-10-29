<?php

namespace App\Providers;

use App\Services\SMS\BulkSMSBD;
use App\Services\SMS\DummySms;
use App\Services\SMS\SMS;
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

        $this->app->singleton(SMS::class, function () {
            if ($this->app->environment('production')) {
                return new BulkSMSBD();
            }

            return new DummySms();
        });
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
