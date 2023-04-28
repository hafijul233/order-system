<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('customer', 'CustomerCrudController');
    Route::crud('address-book', 'AddressBookCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('newsletter', 'NewsletterCrudController');
    Route::crud('campaign', 'CampaignCrudController');
    Route::crud('coupon', 'CouponCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('tag', 'TagCrudController');
    Route::crud('order', 'OrderCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('stock', 'StockCrudController');
    Route::crud('event', 'EventCrudController');
    Route::crud('email', 'EmailCrudController');
    Route::crud('template', 'TemplateCrudController');
    Route::crud('task', 'TaskCrudController');
    Route::crud('country', 'CountryCrudController');
    Route::crud('state', 'StateCrudController');
    Route::crud('city', 'CityCrudController');
    Route::crud('translation', 'TranslationCrudController');
    Route::crud('banner', 'BannerCrudController');
    Route::crud('widget', 'WidgetCrudController');
    Route::crud('page', 'PageCrudController');
    Route::crud('notification', 'NotificationCrudController');
    Route::crud('audit', 'AuditCrudController');
    Route::crud('attribute', 'AttributeCrudController');
    Route::crud('modifier', 'ModifierCrudController');
    Route::crud('unit', 'UnitCrudController');
    Route::crud('status', 'StatusCrudController');
    Route::crud('order-item', 'OrderItemCrudController');
}); // this should be the absolute last line of this file