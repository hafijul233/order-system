<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation, InlineCreateOperation, FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('customer', 'customers');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(setting('frontend_enabled', '0') == '1') {
            CRUD::addFilter(
                ['name' => 'platform', 'type' => 'dropdown', 'label' => 'Platform'],
                config('constant.platforms'),
                fn ($value) => $this->crud->addClause('where', 'platform', '=', $value)
            );
        }
        
        CRUD::addFilter(['name' => 'status', 'type' => 'select2_multiple', 'label' => 'Status'],
            Customer::statusDropdown(),
            fn($value) => $this->crud->addClause('whereIn', 'status_id', json_decode($value, true))
        );

        CRUD::addFilter(['type' => 'simple', 'name' => 'email_verified_at', 'label' => 'Email Verified'],
            false,
            fn() => $this->crud->addClause('where', 'email_verified_at', '!=', null)
        );

        CRUD::addFilter(['type' => 'simple', 'name' => 'phone_verified_at', 'label' => 'Phone Verified'],
            false,
            fn() => $this->crud->addClause('whereNotNull', 'phone_verified_at')
        );

        CRUD::addFilter([ 'name' => 'created_at', 'type' => 'date_range', 'label' => 'Created'],
            false,
            function ($value) { // if the filter is active
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from . ' 00:00:00');
                $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            });

        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => '#',
            ],
            [
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => "<a class='text-dark' href='maiilto:{$customer->email}'>{$customer->email} " . (($customer->email_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>"
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => "<a class='text-dark' href='tel:{$customer->phone}'>{$customer->phone} " . (($customer->phone_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>"
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => $customer->status_html
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime',
                'label' => 'Created'
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomerRequest::class);

        Widget::add()->type('script')->content('js/pages/customer.js');

        CRUD::addFields([
            //Basic Tab
            [
                'name' => 'name',
                'label' => 'Name',
                'tab' => 'Basic'
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'photo',
                'label' => 'Photo',
                'type' => 'browse',
                'tab' => 'Basic',
                'mime_types' => 'image/*',
            ],
            [
                'name' => 'newsletter_subscribed',
                'label' => 'Newsletter Subscribed?',
                'type' => 'boolean',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'allowed_login',
                'label' => 'Customer Allowed to Login on system?',
                'type' => 'boolean',
                'fake' => true,
                'tab' => 'Basic',
                'default' => setting('customer_login', "0"),
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'password_confirmation',
                'label' => 'Confirm Password',
                'type' => 'password',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'email_verified_at',
                'label' => 'Email Verified At',
                'type' => 'datetime_picker',
                'tab' => 'Profile',
                'datetime_picker_options' => [
                    'format' => 'YYYY-MM-DD HH:mm:ss',
                ],
                'allows_null' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'phone_verified_at',
                'label' => 'Phone Verified At',
                'type' => 'datetime_picker',
                'tab' => 'Profile',
                'datetime_picker_options' => [
                    'format' => 'YYYY-MM-DD HH:mm:ss',
                ],
                'allows_null' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            //Profile
            [
                'name' => 'block_reason',
                'label' => 'Suspend/Banned Reason',
                'type' => 'textarea',
                'tab' => 'Profile'
            ],
            [
                'name' => 'note',
                'label' => 'Notes',
                'type' => 'textarea',
                'tab' => 'Profile'
            ],
            [
                'name' => 'status_id',
                'label' => 'Status',
                'type' => 'select2_from_array',
                'options' => Customer::statusDropdown(),
                'default' => Customer::defaultStatusId(),
                'allows_null' => false,
                'tab' => 'Profile',
                'wrapper' => [
                    'class' => 'form-group ' . ((setting('frontend_enabled', '0') == '1') ? 'col-md-6' : 'col-md-12')
                ],
            ],
        ]);

        if(setting('frontend_enabled', '0') == '1') {
            CRUD::addField([
                    'name' => 'platform',
                    'label' => 'Platform',
                    'type' => 'select2_from_array',
                    'options' => config('constant.platforms'),
                    'default' => 'office',
                    'allows_null' => false,
                    'tab' => 'Profile',
                    'wrapper' => [
                        'class' => 'form-group col-md-6'
                    ],
                ]);
        } else {
            CRUD::addField([
                'name' => 'platform',
                'label' => 'Platform',
                'type' => 'hidden',
                'default' => 'office',
                'allows_null' => false,
                'tab' => 'Profile',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ]);
        }
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-show-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => '#',
            ],
            [
                'name' => 'photo',
                'label' => 'Photo',
                'type' => 'image'
            ],
            [
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => "<a class='text-dark' href='maiilto:{$customer->email}'>{$customer->email} " . (($customer->email_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>"
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => "<a class='text-dark' href='tel:{$customer->phone}'>{$customer->phone} " . (($customer->phone_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>"
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => $customer->status_html
            ],
            [
                'name' => 'platform',
                'label' => 'Platform',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => $customer->platform_html
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime',
                'label' => 'Created'
            ],
        ]);

        if(setting('display_activity_log') == '1') {
            Widget::add([
                'type' => 'audit',
                'section' => 'after_content',
                'wrapper' => ['class' => 'col-md-12 px-0'],
                'header' => "<h5 class='card-title mb-0'>CustomerActivity Logs</h5>",
                'crud' => $this->crud,
            ]);
        }
    }

    protected function fetchCustomer()
    {
        return $this->fetch(Customer::class);
    }
}
