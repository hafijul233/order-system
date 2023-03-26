<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StateRequest;
use App\Models\Country;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class StateCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\State::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/state');
        CRUD::setEntityNameStrings('state', 'states');
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
                'name' => 'country',
                'label' => 'Country',
                'type' => 'custom_html',
                'value' => function ($state) {
                    return "{$state->country->flag} {$state->country->name}";
                }
            ],
            [
                'name' => 'type',
                'label' => 'Type',
            ],
            [
                'name' => 'iso2',
                'label' => 'ISO2 Code',
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled',
                'type'=> 'boolean'
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
        CRUD::setValidation(StateRequest::class);


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
                'name' => 'type',
                'label' => 'Type',
            ],
            [
                'name' => 'iso2',
                'label' => 'ISO2 Code',
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
}
