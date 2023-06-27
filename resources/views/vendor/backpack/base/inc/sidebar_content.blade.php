{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<li class="nav-title">Contact</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('customer') }}">
        <i class="nav-icon la la-user-check"></i>
        Customers
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('address-book') }}">
        <i class="nav-icon la la-address-book"></i>
        Address books
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('company') }}">
        <i class="nav-icon la la-building"></i>
        Companies
    </a>
</li>

<li class="nav-title">Marchandise</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('product') }}">
        <i class="nav-icon la la-box"></i>
        {{ ucfirst(\Str::plural(setting('item_label', 'product'))) }}
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('category') }}">
        <i class="nav-icon la la-tree"></i>
        Categories
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('attribute') }}">
        <i class="nav-icon la la-list"></i>
        Attributes
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('modifier') }}">
        <i class="nav-icon la la-edit"></i>
        Modifiers
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('brand') }}">
        <i class="nav-icon la la-question"></i>
        Brands
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('unit') }}">
        <i class="nav-icon la la-balance-scale"></i>
        Units
    </a>
</li>

<li class="nav-title">Sale</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('quote') }}">
        <i class="nav-icon la la-file-invoice"></i>
        Quotes
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('order') }}">
        <i class="nav-icon la la-cart-arrow-down"></i>
        {{ ucfirst(\Str::plural(setting('order_label', 'order'))) }}
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('payment') }}">
        <i class="nav-icon la la-usd"></i>
        Payments
    </a>
</li>
<li class="nav-title">Inventory</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('tag') }}">
        <i class="nav-icon la la-tags"></i>
        Tags
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('stock') }}">
        <i class="nav-icon la la-pie-chart"></i>
        Stocks
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('warehouse') }}">
        <i class="nav-icon la la-question"></i>
        Warehouses
    </a>
</li>
<li class="nav-title">Marketing</li>
@if (setting('developer_mode'))
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('email') }}">
            <i class="nav-icon la la-envelope"></i>
            Emails
        </a>
    </li>
@endif
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('newsletter') }}">
        <i class="nav-icon la la-newspaper"></i>
        Newsletters
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('campaign') }}">
        <i class="nav-icon la la-calendar"></i>
        Campaigns
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('coupon') }}">
        <i class="nav-icon la la-percent"></i>
        Coupons
    </a>
</li>

<li class="nav-title">CMS</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('banner') }}">
        <i class="nav-icon la la-image"></i>
        Banners
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('widget') }}">
        <i class="nav-icon la la-plug"></i>
        Widgets
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('page') }}">
        <i class="nav-icon la la-file-image"></i>
        Pages
    </a>
</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}">
        <i class="nav-icon la la-files-o"></i>
        Media
    </a>
</li>

<li class="nav-title">Notification</li>
@if (setting('developer_mode'))
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('event') }}">
            <i class="nav-icon la la-calendar-day"></i>
            Events
        </a>
    </li>
@endif
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('template') }}">
        <i class="nav-icon la la-paperclip"></i>
        Templates
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('task') }}">
        <i class="nav-icon la la-tasks"></i>
        Tasks
    </a>
</li>
<li class="nav-title">Authorization</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('user') }}">
        <i class="nav-icon la la-user"></i>
        Users
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('role') }}">
        <i class="nav-icon la la-id-badge"></i>
        Roles
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('permission') }}">
        <i class="nav-icon la la-key"></i>
        Permissions
    </a>
</li>
@if (setting('developer_mode'))
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('audit') }}">
            <i class="nav-icon la la-search"></i>
            Activity Log
        </a>
    </li>
@endif
<li class="nav-title">General</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('country') }}">
        <i class="nav-icon la la-map"></i>
        Countries
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('state') }}">
        <i class="nav-icon la la-landmark"></i>
        States
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('city') }}">
        <i class="nav-icon la la-map-pin"></i>
        Cities
    </a>
</li>
<li class="nav-title">Localization</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('language') }}">
        <i class="nav-icon la la-language"></i>
        Languages
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('translation') }}">
        <i class="nav-icon la la-language"></i>
        Translations
    </a>
</li>

<li class="nav-title">Tweaks</li>
<li class="nav-item">
    <a class="nav-link" href='{{ backpack_url('setting') }}'>
        <i class='nav-icon la la-cog'></i>Settings
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('status') }}">
        <i class="nav-icon la la-info"></i>
        Statuses
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('payment-option') }}">
        <i class="nav-icon la la-question"></i>
        Payment Options
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href='{{ backpack_url('log') }}'>
        <i class='nav-icon la la-terminal'></i>
        Logs
    </a>
</li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>