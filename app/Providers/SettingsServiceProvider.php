<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // only use the Settings package if the Settings table is present in the database
        if (is_installed()) {
            // get all settings from the database
            $settings = Setting::all();

            $config_prefix = config('backpack.settings.config_prefix');

            foreach ($settings as $key => $setting) {
                $prefixed_key = !empty($config_prefix) ? $config_prefix.'.'.$setting->key : $setting->key;
                Config::set($prefixed_key, $setting->value);
            }
        }
    }
}
