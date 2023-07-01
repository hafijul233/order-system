<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Customer;
use App\Observers\CategoryObserver;
use App\Observers\CustomerObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Customer::observe(CustomerObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
