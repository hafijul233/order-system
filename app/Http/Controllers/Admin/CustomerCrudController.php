<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\Status;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation, InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Customer::class);
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
        CRUD::addFilter(['name' => 'type', 'type' => 'dropdown', 'label' => 'Type'],
            Customer::TYPES,
            fn($value) => $this->crud->addClause('where', 'type', '=', $value)
        );

        CRUD::addFilter(['name' => 'status', 'type' => 'select2_multiple', 'label' => 'Status'],
            Customer::statusDropdown(),
            function ($value) {
                $this->crud->addClause(function ($query) use ($value) {
                    $query->whereHas('status', fn($query) => $query->whereIn('id', json_decode($value)));
                });
            });

        CRUD::addFilter(['type' => 'simple', 'name' => 'email_verified_at', 'label' => 'Email Verified'],
            false,
            fn() => $this->crud->addClause('where', 'email_verified_at', '!=', null)
        );

        CRUD::addFilter(['type' => 'simple', 'name' => 'phone_verified_at', 'label' => 'Phone Verified'],
            false,
            fn () =>  $this->crud->addClause('whereNotNull', 'phone_verified_at')
        );

        CRUD::addFilter(
            [
                'name' => 'created_at',
                'type' => 'date_range',
                'label' => 'Created'
            ],
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
                'name' => 'type',
                'label' => 'Type',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => $customer->typeHTML()
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
                'value' => fn(Customer $customer) => $customer->statusHTML()
            ]
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
                'tab' => 'Basic'
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'tab' => 'Basic'
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'select2_from_array',
                'options' => Customer::TYPES,
                'allows_null' => false,
                'tab' => 'Basic'
            ],
            //Authentication Tab
            [
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
                'tab' => 'Authentication'
            ],
            [
                'name' => 'password_confirmation',
                'label' => 'Confirm Password',
                'type' => 'password',
                'tab' => 'Authentication'
            ],
            [
                'name' => 'email_verified_at',
                'label' => 'Email Verified At',
                'type' => 'datetime_picker',
                'tab' => 'Authentication',
                'datetime_picker_options' => [
                    'format' => 'YYYY-MM-DD HH:mm:ss',
                ],
                'allows_null' => true,
            ],
            [
                'name' => 'phone_verified_at',
                'label' => 'Phone Verified At',
                'type' => 'datetime_picker',
                'tab' => 'Authentication',
                'datetime_picker_options' => [
                    'format' => 'YYYY-MM-DD HH:mm:ss',
                ],
                'allows_null' => true,
            ],
            //Profile
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select2_from_array',
                'options' => Customer::statusDropdown(),
                'allows_null' => false,
                'tab' => 'Profile'
            ],
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
                'name' => 'newsletter_subscribed',
                'label' => 'Newsletter Subscribed?',
                'type' => 'boolean',
                'tab' => 'Promotion'
            ],
        ]);
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
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
            ],
            [
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email'
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => "<a href='tel:{$customer->phone}'>{$customer->phone}</a>"
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => $customer->typeHTML()
            ],
            [
                'name' => 'email_verified_at',
                'label' => 'Email Verified At',
                'type' => 'datetime',
            ],
            [
                'name' => 'phone_verified_at',
                'label' => 'Phone Verified At',
                'type' => 'datetime',
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => fn(Customer $customer) => $customer->statusHTML()
            ],
            [
                'name' => 'block_reason',
                'label' => 'Suspend/Banned Reason',
                'type' => 'textarea'
            ],
            [
                'name' => 'note',
                'label' => 'Notes',
                'type' => 'textarea'
            ],
            [
                'name' => 'newsletter_subscribed',
                'label' => 'Newsletter Subscribed?',
                'type' => 'boolean'
            ]
        ]);
    }
}
