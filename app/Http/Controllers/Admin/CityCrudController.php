<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Illuminate\Http\JsonResponse;


/**
 * Class CityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(City::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/city');
        CRUD::setEntityNameStrings('city', 'cities');
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
                'type' => 'dropdown',
                'name' => 'enabled',
                'label' => 'Enabled'
            ],
            [
                1 => 'Yes',
                0 => 'No',

            ],
            function ($value) {
                $this->crud->addClause('where', 'enabled', '=', $value);
            });

        CRUD::addFilter(
            [
                'type' => 'select2',
                'name' => 'country',
                'label' => 'Country'
            ],
            function () {
                return Country::all()->pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'country_id', '=', $value);
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
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'country_id',
                'label' => 'Country',
                'type' => 'custom_html',
                'value' => function (City $city) {
                    return "{$city->country->flag} {$city->country->name}";
                }
            ],
            [
                'name' => 'state_id',
                'label' => 'State',
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled',
                'type' => 'boolean'
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
        CRUD::setValidation(CityRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'Name',
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
                'data_source' => backpack_url("city/fetch/state"),
                'dependencies' => ['country'],
                'method' => 'POST',
                'minimum_input_length' => 0,
                'include_all_form_fields' => true,
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled',
                'type' => 'boolean'
            ]
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
     * return a list of states with county condition
     * @link {app_url}/admin/city/fetch/state
     *
     * @return array|JsonResponse
     */
    protected function fetchState()
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
}
