<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddressBookRequest;
use App\Models\AddressBook;
use App\Models\City;
use App\Models\Company;
use App\Models\Customer;
use App\Models\State;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

/**
 * Class AddressBookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AddressBookCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation, FetchOperation;

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
        CRUD::addFilter(
            [
                'name' => 'type',
                'type' => 'dropdown',
                'label' => 'Type'
            ],
            AddressBook::TYPES,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'type', '=', $value);
            });

        CRUD::addFilter(['name' => 'status', 'type' => 'select2_multiple', 'label' => 'Status'],
            AddressBook::statusDropdown(),
            function ($value) {
                $this->crud->addClause(function ($query) use ($value) {
                    $query->whereHas('status', fn($query) => $query->whereIn('status_id', json_decode($value)));
                });
            });

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
                'name' => 'addressable',
                'label' => 'Address To',
                'type' => 'custom_html',
                'value' => function ($addressBook) {
                    return $this->addressableModel($addressBook);
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
                'value' => function ($addressBook) {
                    return "<a class='text-dark' href='tel:{$addressBook->phone}'>{$addressBook->phone} " . (($addressBook->phone_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>";
                }
            ],
            [
                'name' => 'address',
                'label' => 'Address',
                'type' => 'custom_html',
                'value' => function ($addressBook) {
                    return "<span>{$addressBook->street_address}<br>
{$addressBook->city->name}, {$addressBook->state->name} - {$addressBook->zip_code}<br>
{$addressBook->country->name}</span>";
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

        CRUD::addFields([
            [
                'name' => 'addressable',
                'label' => 'Address To',
                'type' => 'relationship',
                'allows_null' => false,
                'tab' => 'Basic',
                'morphOptions' => [
                    [Customer::class,],
                    [Company::class,]
                ]
            ],
            ['name' => 'type',
                'label' => 'Type',
                'type' => 'select2_from_array',
                'options' => AddressBook::TYPES,
                'allows_null' => false,
                'tab' => 'Basic',
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'tab' => 'Basic',
            ],
            [
                'name' => 'street_address',
                'label' => 'Street Address',
                'type' => 'textarea',
                'tab' => 'Basic',
            ],
            [
                'name' => 'country',
                'label' => 'Country',
                'type' => 'select2',
                'entity' => 'country',
                'allows_null' => false,
                'options' => (function ($query) {
                    return $query->enabled()->get();
                }),
                'tab' => 'Basic'
            ],
            [
                'name' => 'state',
                'label' => 'State',
                'type' => 'relationship',
                'entity' => 'state',
                'ajax' => true,
                'attribute' => "name",
                'placeholder' => "Select a state",
                // AJAX OPTIONALS:
                'delay' => 500,
                'data_source' => backpack_url("address-book/fetch/state"),
                'dependencies' => ['country'],
                'method' => 'POST',
                'minimum_input_length' => 0,
                'include_all_form_fields' => true,
                'tab' => 'Basic'
            ],
            [
                'name' => 'city',
                'label' => 'State',
                'type' => 'relationship',
                'entity' => 'city',
                'ajax' => true,
                'attribute' => "name",
                'placeholder' => "Select a city",
                // AJAX OPTIONALS:
                'delay' => 500,
                'data_source' => backpack_url("address-book/fetch/city"),
                'dependencies' => ['country', 'state'],
                'method' => 'POST',
                'minimum_input_length' => 0,
                'include_all_form_fields' => true,
                'tab' => 'Basic'
            ],
            [
                'name' => 'zip_code',
                'label' => 'Zip Code',
                'type' => 'number',
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
                'type' => 'select2_from_array',
                'options' => AddressBook::statusDropdown(),
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
     * Define what happens when the Show operation is loaded.
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
                'name' => 'addressable',
                'label' => 'Address To',
                'type' => 'custom_html',
                'value' => function ($addressBook) {
                    return $this->addressableModel($addressBook);
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
                'name' => 'street_address',
                'label' => 'Street Address',
                'type' => 'textarea',
            ],
            [
                'name' => 'city',
                'label' => 'City'
            ],
            [
                'name' => 'state',
                'label' => 'State'
            ],
            [
                'name' => 'country',
                'label' => 'Country'
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

    private function addressableModel($addressBook)
    {
        if ($addressBook->addressable instanceof Customer) {
            return "<a class='text-dark' title='Customer' target='_blank' href='" . route('customer.show', $addressBook->addressable->id) . "'><i class='la la-user text-info'></i> {$addressBook->addressable->name}</a>";
        } elseif ($addressBook->addressable instanceof Company) {
            return "<a class='text-dark' title='Company' target='_blank' href='" . route('company.show', $addressBook->addressable->id) . "'><i class='la la-building text-success'></i> {$addressBook->addressable->name}</a>";
        } else {
            return '-';
        }
    }

    /**
     * return a list of states with county condition
     * @return array|JsonResponse
     * @link {app_url}/admin/address-book/fetch/state
     *
     */
    public function fetchState()
    {
        $country = null;
        $request = request('form', []);

        foreach ($request as $field) {
            if (isset($field['name']) && $field['name'] == 'country') {
                $country = $field['value'];
                break;
            }
        }

        if ($country) {

            return $this->fetch([
                'model' => State::class,
                'paginate' => false,
                'query' => function (State $state) use (&$country) {
                    return $state->enabled()->where('country_id', '=', $country);
                }
            ]);
        } else {
            return [];
        }
    }

    /**
     * return a list of states with county condition
     * @return array|JsonResponse
     * @link {app_url}/admin/address-book/fetch/city
     *
     */
    public function fetchCity()
    {
        $country = null;
        $state = null;

        $request = request('form', []);

        foreach ($request as $field) {
            if (isset($field['name']) && $field['name'] == 'country') {
                $country = $field['value'];
            }
            if (isset($field['name']) && $field['name'] == 'state') {
                $state = $field['value'];
                if ($country) {
                    break;
                }
            }

        }

        if ($country) {

            return $this->fetch([
                'model' => City::class,
                'paginate' => false,
                'query' => function (City $city) use ($country, $state) {
                    return $city->enabled()
                        ->where('country_id', '=', $country)
                        ->when($state, function (Builder $query) use ($state) {
                            return $query->where('state_id', '=', $state);
                        });
                }
            ]);
        } else {
            return [];
        }
    }
}
