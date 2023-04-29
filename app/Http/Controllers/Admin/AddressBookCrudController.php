<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddressBookRequest;
use App\Models\AddressBook;
use App\Models\City;
use App\Models\Company;
use App\Models\Customer;
use App\Models\State;
use Backpack\CRUD\app\Exceptions\BackpackProRequiredException;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

/**
 * Class AddressBookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AddressBookCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation, FetchOperation, InlineCreateOperation;

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
            function ($value) {
                $this->crud->addClause('where', 'type', '=', $value);
            });

        CRUD::addFilter(['name' => 'status', 'type' => 'select2_multiple', 'label' => 'Status'],
            AddressBook::statusDropdown(),
            fn($value) => $this->crud->addClause('whereIn', 'status_id', json_decode($value))
        );

        CRUD::addFilter(
            [
                'name' => 'created_at',
                'type' => 'date_range',
                'label' => 'Created'
            ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('whereBetween', 'created_at', [$dates->from . ' 00:00:00', $dates->to . ' 23:59:59']);
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
                'value' => fn(AddressBook $addressBook) => $addressBook->addressable_html
            ],
            [
                'name' => 'name',
                'label' => 'Title',
                'hint' => 'Head Office, Branch Name, Unique Reference'
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'custom_html',
                'value' => fn(AddressBook $addressBook) => $addressBook->type_html,

            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'type' => 'custom_html',
                'value' => function (AddressBook $addressBook) {
                    return "<a class='text-dark' href='tel:{$addressBook->phone}'>{$addressBook->phone} " . (($addressBook->phone_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>";
                }
            ],
            [
                'name' => 'address',
                'label' => 'Address',
                'type' => 'custom_html',
                'value' => fn(AddressBook $addressBook) => $addressBook->full_address_html
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => fn(AddressBook $addressBook) => $addressBook->status_html,
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
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'select2_from_array',
                'options' => AddressBook::TYPES,
                'allows_null' => false,
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'name',
                'label' => 'Title',
                'hint' => 'N.B: Required for company entries',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6 mb-md-0 mb-3'
                ],
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
                'options' => fn($query) => $query->enabled()->get(),
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
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
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'city',
                'label' => 'City',
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
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'zip_code',
                'label' => 'Zip Code',
                'type' => 'number',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'status_id',
                'label' => 'Status',
                'type' => 'select2_from_array',
                'options' => AddressBook::statusDropdown(),
                'default' => AddressBook::defaultStatusId(),
                'allows_null' => false,
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            //Recognition Tab
            [
                'name' => 'landmark',
                'label' => 'Land Mark',
                'type' => 'text',
                'tab' => 'Recognition',
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
                'value' => fn(AddressBook $addressBook) => $addressBook->addressable_html,
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'custom_html',
                'value' => fn(AddressBook $addressBook) => $addressBook->type_html,
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
                'value' => fn($addressBook) => $addressBook->statusHtml,
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
