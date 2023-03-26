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

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;

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
                'value' => function ($customer) {
                    return $this->customerType($customer);
                }
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'custom_html',
                'value' => function ($customer) {
                    return "<a class='text-dark' href='maiilto:{$customer->email}'>{$customer->email} " . (($customer->email_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>";
                }
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'type' => 'custom_html',
                'value' => function ($customer) {
                    return "<a class='text-dark' href='tel:{$customer->phone}'>{$customer->phone} " . (($customer->phone_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>";
                }
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => function ($customer) {
                    return $this->customerStatus($customer);
                }
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
                'type' => 'select_from_array',
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
                'type' => 'select_from_array',
                'options' => Customer::STATUSES,
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
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
                'value' => function ($customer) {
                    return "<a href='tel:{$customer->phone}'>{$customer->phone}</a>";
                }
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'custom_html',
                'value' => function ($customer) {
                    return $this->customerType($customer);
                }
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
                'value' => function ($customer) {
                    return $this->customerStatus($customer);
                }
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

    private function customerType($customer)
    {
        return match ($customer->type) {
            'online' => "<span class='text-success'><i class='la la-globe-asia'></i> " . Customer::TYPES[$customer->type] . "</span>",
            'offline' => "<span class='text-black-50'><i class='la la-building'></i> " . Customer::TYPES[$customer->type] . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
    }

    private function customerStatus($customer)
    {
        return match ($customer->status) {
            'active' => "<span class='text-success'><i class='la la-check'></i> " . Customer::STATUSES[$customer->status] . "</span>",
            'suspended' => "<span class='text-warning'><i class='la la-warning'></i> " . Customer::STATUSES[$customer->status] . "</span>",
            'banned' => "<span class='text-danger'><i class='la la-times'></i> " . Customer::STATUSES[$customer->status] . "</span>",
        };
    }
}
