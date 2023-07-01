<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CountryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CountryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CountryCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Country::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/country');
        CRUD::setEntityNameStrings('country', 'countries');
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
                'type' => 'custom_html',
                'value' => function($country) {
                    return "{$country->flag} {$country->name}";
                }
            ],
            [
                'name' => 'phone',
                'label' => 'Phone Code',
            ],
            [
                'name' => 'currency',
                'label' => 'Currency',
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
        CRUD::setValidation(CountryRequest::class);

        CRUD::addFields([
            [
                'name' => 'flag',
                'label' => 'Flag'
            ],
            [
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'iso2',
                'label' => 'ISO2 Code',
            ],
            [
                'name' => 'iso3',
                'label' => 'ISO3 Code',
            ],
            [
                'name' => 'phone',
                'label' => 'Phone Code',
            ],
            [
                'name' => 'currency',
                'label' => 'Currency',
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled',
                'type'=> 'boolean'
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
