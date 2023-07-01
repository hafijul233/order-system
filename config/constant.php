<?php

use App\Models\AddressBook;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderNote;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Email;
use App\Models\NewsLetter;
use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\Banner;
use App\Models\Page;
use App\Models\Template;
use App\Models\Task;
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
        Brand::class => 'Brand',
        Category::class => 'Category',
        Company::class => 'Company',
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
    ],
    'product_visibility' => [
        'web' => 'Online',
        'store' => 'Offline',
        'both' => 'Both'
    ]
];