<?php

namespace Whyounes\FaqException\Providers;

use Illuminate\Support\ServiceProvider;

class FaqProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../resources/migrations');
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/faq.php', 'faq'
        );
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'faq');
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/faq'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}