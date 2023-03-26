<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CityRequest;
use App\Models\City;
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
                'name' => 'country',
                'label' => 'Country',
                'type' => 'custom_html',
                'value' => function (City $city) {
                    return "{$city->country->flag} {$city->country->name}";
                }
            ],
            [
                'name' => 'state',
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
                'name' => 'country_id',
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
}
