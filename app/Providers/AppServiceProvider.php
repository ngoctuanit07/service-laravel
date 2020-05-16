<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider {
    /**
    * Register any application services.
    *
    * @return void
    */

    public function register() {
        //
        // $this->app->singleton(\Services\KeywordsFetcher::class, function ($app) {
        //     $client = new \Services\KeywordsFetcher();
        //     return $client;
        // });
    }

    /**
    * Bootstrap any application services.
    *
    * @return void
    */

    public function boot() {
        //
        URL::forceScheme( 'https' );
    }
}
