<?php

namespace App\Providers;

use App\Observers\CustomerObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(ObserverServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->overrideConfigValues();
    }

    private function overrideConfigValues()
    {
        $config = [];
        if (config('settings.developer_mode') == '1') {
            $config['app.debug'] = true;
            $config['app.env'] = 'local';
            $config['debugbar.enabled'] = true;
        } else {
            $config['app.debug'] = false;
            $config['app.env'] = 'production';
            $config['debugbar.enabled'] = false;
        }

/*        if (config('settings.skin'))
            $config['backpack.base.skin'] = config('settings.skin');
        if (config('settings.show_powered_by'))
            $config['backpack.base.show_powered_by'] = config('settings.show_powered_by') == '1';*/
        config($config);
    }
}
