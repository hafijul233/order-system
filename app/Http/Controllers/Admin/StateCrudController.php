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
        CRUD::addColumns([
            [
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'type',
                'label' => 'Type',
            ],
            [
                'name' => 'country',
                'label' => 'Country',
            ],
            [
                'name' => 'iso2',
                'label' => 'ISO3 Code',
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

        $countries = [];

        Country::all()->each(function ($country) use (&$countries){
            $countries[$country->id] = "{$country->flag} {$country->name}";
        });

        CRUD::addColumns([
            [
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'type',
                'label' => 'Type',
            ],
            [
                'name' => 'country_id',
                'label' => 'Country',
                'type' => 'select_from_array',
                'options' => $countries
            ],
            [
                'name' => 'iso2',
                'label' => 'ISO3 Code',
            ]
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
}
