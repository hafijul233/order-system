<?php

use App\Models\AddressBook;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Company;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\OrderNote;
use App\Models\Warehouse;

return [
    'address_type' => [
        'home' => 'Home',
        'ship' => 'Delivery',
        'bill' => 'Billing',
        'work' => 'Work',
        'other' => 'Other',
    ],
    'platforms' => [
        'android' => 'Android App',
        'ios' => 'iOS App',
        'website' => 'Web Site',
        'office' => 'System',
        'store' => 'Store',
    ],
    'status_model' => [
        AddressBook::class => 'Address Book',
        Banner::class => 'Banner',
        Brand::class => 'Brand',
        Campaign::class => 'Campaign',
        Category::class => 'Category',
        Company::class => 'Company',
        Coupon::class => 'Coupon',
        Customer::class => 'Customer',
        Order::class => 'Order',
        OrderItem::class => 'Order Item',
        OrderNote::class => 'Order Note',
        Payment::class => 'Payment',
        Product::class => 'Product',
        Stock::class => 'Stock',
        Email::class => 'Email',
        NewsLetter::class => 'NewsLetter',
        Campaign::class => 'Campaign',
        Coupon::class => 'Coupon',
        Banner::class => 'Banner',
        Page::class => 'Page',
        Template::class => 'Template',
        Task::class => 'Task',
        Warehouse::class => 'Warehouse'
    ],
    'payment_type' => [
        'cash' => 'Cash',
        'bank' => 'Bank Account',
        'wallet' => 'E-Wallet'
    ],
    'attribute_type' => [
        'text' => 'Text',
        'number' => 'Number',
    ],
    'form_excluded_fields' => [
        '_token',
        '_http_referrer',
        '_current_tab',
        '_save_action'
    ]
];