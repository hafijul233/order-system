<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddressBookRequest;
use App\Models\AddressBook;
use App\Models\Company;
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
 * Class AddressBookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AddressBookCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\AddressBook::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/address-book');
        CRUD::setEntityNameStrings('address book', 'address books');
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
                'name' => 'addressable',
                'label' => 'Address To',
                'type' => 'custom_html',
                'value' => function ($addressBook) {
                    if ($addressBook->addressable instanceof Customer) {
                        return "<a class='text-dark' title='Customer' target='_blank' href='" . route('customer.show', $addressBook->addressable->id) . "'><i class='la la-user text-info'></i> {$addressBook->addressable->name}</a>";
                    } elseif ($addressBook->addressable instanceof Company) {
                        return "<a class='text-dark' title='Company' target='_blank' href='" . route('company.show', $addressBook->addressable->id) . "'><i class='la la-building text-success'></i> {$addressBook->addressable->name}</a>";
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'custom_html',
                'value' => function ($addressBook) {
                    return $this->addressBookType($addressBook);
                },
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
                'value' => function ($addressBook) {
                    return $this->addressBookStatus($addressBook);
                }
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
        CRUD::setValidation(AddressBookRequest::class);

        $addressable = [];

        Customer::all()->each(function ($customer) use (&$addressable) {
            $addressable[Customer::class . ':' . $customer->id] = $customer->name;
        });

        Company::all()->each(function ($company) use (&$addressable) {
            $addressable[Company::class . ':' . $company->id] = $company->name;
        });

        CRUD::addFields([
            [
                'name' => 'addressable',
                'label' => 'Address To',
                'type' => 'select_from_array',
                'options' => $addressable,
                'allows_null' => false,
                'tab' => 'Basic',
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'select_from_array',
                'options' => AddressBook::TYPES,
                'allows_null' => false,
                'tab' => 'Basic',
            ],
            [
                'name' => 'street_address',
                'label' => 'Street Address',
                'type' => 'textarea',
                'tab' => 'Basic',
            ],
            [
                'name' => 'city',
                'label' => 'City',
                'type' => 'text',
                'tab' => 'Basic',
            ],
            [
                'name' => 'state',
                'label' => 'State',
                'type' => 'text',
                'tab' => 'Basic',
            ],
            [
                'name' => 'zip_code',
                'label' => 'Zip Code',
                'type' => 'number',
                'tab' => 'Basic',
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'tab' => 'Basic',
            ],
            //Recognition Tab
            [
                'name' => 'landmark',
                'label' => 'Land Mark',
                'type' => 'text',
                'tab' => 'Recognition',
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select_from_array',
                'options' => AddressBook::STATUSES,
                'allows_null' => false,
                'tab' => 'Recognition'
            ],
            [
                'name' => 'block_reason',
                'label' => 'Suspend/Banned Reason',
                'type' => 'textarea',
                'tab' => 'Recognition'
            ],
            [
                'name' => 'note',
                'label' => 'Notes',
                'type' => 'textarea',
                'tab' => 'Recognition'
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
                'name' => 'customer',
                'label' => 'Customer'
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'custom_html',
                'value' => function ($addressBook) {
                    return $this->addressBookType($addressBook);
                },
            ],
            [
                'name' => 'street_address',
                'label' => 'Street Address',
                'type' => 'textarea',
            ],
            [
                'name' => 'city',
                'label' => 'City',
                'type' => 'text'
            ],
            [
                'name' => 'state',
                'label' => 'State',
                'type' => 'text',
                'tab' => 'Basic',
            ],
            [
                'name' => 'zip_code',
                'label' => 'Zip Code',
                'type' => 'number'
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
            ],
            //Recognition Tab
            [
                'name' => 'landmark',
                'label' => 'Land Mark',
                'type' => 'text'
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => function ($addressBook) {
                    return $this->addressBookStatus($addressBook);
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

        ]);
    }

    private function addressBookType(AddressBook $addressBook)
    {
        return match ($addressBook->type) {
            'home' => "<span class='text-info'><i class='la la-home'></i> " . AddressBook::TYPES[$addressBook->type] . "</span>",
            'ship' => "<span class='text-info'><i class='la la-shipping-fast'></i> " . AddressBook::TYPES[$addressBook->type] . "</span>",
            'bill' => "<span class='text-info'><i class='la la-file-invoice-dollar'></i> " . AddressBook::TYPES[$addressBook->type] . "</span>",
            'work' => "<span class='text-info'><i class='la la-user-graduate'></i> " . AddressBook::TYPES[$addressBook->type] . "</span>",
            'other' => "<span class='text-info'><i class='la la-exclamation'></i> " . AddressBook::TYPES[$addressBook->type] . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
    }

    private function addressBookStatus($addressBook)
    {
        return match ($addressBook->status) {
            'active' => "<span class='text-success'><i class='la la-check'></i> " . AddressBook::STATUSES[$addressBook->status] . "</span>",
            'suspended' => "<span class='text-warning'><i class='la la-warning'></i> " . AddressBook::STATUSES[$addressBook->status] . "</span>",
            'banned' => "<span class='text-danger'><i class='la la-times'></i> " . AddressBook::STATUSES[$addressBook->status] . "</span>",
        };
    }
}
