<?php

namespace App\Providers;

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
        $this->app->singleton(\Tectalic\OpenAi\Client\Client::class, function ($app) {
            if (\Tectalic\OpenAi\Manager::isGlobal()) {
                // Tectalic OpenAI REST API Client already built.
                return \Tectalic\OpenAi\Manager::access();
            }
            /**
             * Build the Tectalic OpenAI REST API Client globally.
             * @see https://tectalic.com/apis/openai/docs#usage 
             */
            $auth = new \Tectalic\OpenAi\Authentication(config('services.openai.token'));
            $httpClient = new \GuzzleHttp\Client();
            return \Tectalic\OpenAi\Manager::build($httpClient, $auth);
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
