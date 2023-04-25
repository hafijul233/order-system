<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        $this->startQueryLogger();

    }

    private function overrideConfigValues()
    {
        $config = [];

        if (config('settings.developer_mode') == '1') {
            $config['app.debug'] = true;
            $config['app.env'] = 'local';
            $config['debugbar.enabled'] = true;
        }

        Config::set($config);
    }

    private function startQueryLogger()
    {
        if (config('settings.query_logger') == '1') {
            DB::listen(function (QueryExecuted $query) {

                $bindings = $query->bindings ?? [];

                $sql = '';

                foreach (str_split($query->sql) as $char) {
                    if ($char == '?') {
                        $param = array_shift($bindings);
                        $sql .= "'" . addslashes($param) . "'";
                        continue;
                    }
                    $sql .= $char;
                }

                Log::channel('query')->info("SQL: {$sql};");
            });
        }
    }
}
