{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-diamond"></i> Contacts</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}"><i
                    class="nav-icon la la-user-check"></i> Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('address-book') }}"><i
                    class="nav-icon la la-address-book"></i> Address books</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('company') }}"><i
                    class="nav-icon la la-building"></i> Companies</a></li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-business-time"></i> Business</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}">
                <i class="nav-icon la la-box"></i> Products</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('order') }}">
                <i class="nav-icon la la-file-invoice"></i> Orders</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}">
                <i class="nav-icon la la-usd"></i> Payments</a>
        </li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-boxes"></i> Inventory</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}">
                <i class="nav-icon la la-tree"></i> Categories</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}">
                <i class="nav-icon la la-tags"></i> Tags</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('stock') }}">
                <i class="nav-icon la la-pie-chart"></i> Stocks</a>
        </li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-bullseye"></i> Promotions</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('email') }}">
                <i class="nav-icon la la-envelope"></i> Emails</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('newsletter') }}">
                <i class="nav-icon la la-newspaper"></i> Newsletters</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('campaign') }}">
                <i class="nav-icon la la-calendar"></i> Campaigns</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('coupon') }}">
                <i class="nav-icon la la-percent"></i> Coupons</a>
        </li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-globe"></i> Web Site</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('banner') }}">
                <i class="nav-icon la la-question"></i> Banners</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('widget') }}">
                <i class="nav-icon la la-question"></i> Widgets</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('page') }}">
                <i class="nav-icon la la-question"></i> Pages</a>
        </li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-bell"></i> Notifications</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('event') }}">
                <i class="nav-icon la la-calendar-day"></i> Events</a>
        </li>

        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('template') }}">
                <i class="nav-icon la la-paperclip"></i> Templates</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('task') }}">
                <i class="nav-icon la la-tasks"></i> Tasks</a>
        </li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-id-card"></i> Authorizations</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}">
                <i class="nav-icon la la-user"></i>
                <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                    class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                    class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-gears"></i> Tweaks</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'>
                <i class='nav-icon la la-cog'></i>Settings</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('country') }}"><i
                    class="nav-icon la la-map"></i> Countries</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('state') }}"><i
                    class="nav-icon la la-landmark"></i> States</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('city') }}"><i
                    class="nav-icon la la-map-pin"></i> Cities</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('translation') }}"><i
                    class="nav-icon la la-language"></i> Translations</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i
                    class='nav-icon la la-terminal'></i> Logs</a></li>
    </ul>
</li>
