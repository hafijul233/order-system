<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StockRequest;
use App\Models\Stock;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StockCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StockCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Stock::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/stock');
        CRUD::setEntityNameStrings('stock', 'stocks');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addFilter(['name' => 'status', 'type' => 'select2_multiple', 'label' => 'Status'],
            Stock::statusDropdown(),
            fn($value) => $this->crud->addClause('whereIn', 'status_id', json_decode($value, true))
        );

        CRUD::addColumns([
           [
               'name' => 'batch',
               'label' => 'Batch No.',
               'type' => 'text',
           ],
            [
               'name' => 'manufacture_date',
               'label' => 'Manufactured Date',
               'type' => 'date',
           ],
            [
               'name' => 'expiry_date',
               'label' => 'Expired Date',
               'type' => 'date',
           ],
            [
               'name' => 'quantity',
               'label' => 'Quantity',
               'type' => 'number',
           ],
            [
               'name' => 'unit_id',
               'label' => 'Unit',
               'type' => 'number',
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
        CRUD::setValidation(StockRequest::class);

        CRUD::addFields([
            [
                'name' => 'product_id',
                'label' => ucfirst(setting('item_label', 'product')),
                'type' => 'select2',
                'entity' => 'product',
                'attribute' => 'name',
            ],
            [
                'name' => 'batch',
                'label' => 'Batch No.',
                'type' => 'text',
            ],
            [
                'name' => 'manufacture_date',
                'label' => 'Manufactured Date',
                'type' => 'date',
            ],
            [
                'name' => 'expiry_date',
                'label' => 'Expired Date',
                'type' => 'date',
            ],
            [
                'name' => 'unit_id',
                'label' => 'Unit',
                'type' => 'select2',
                'entity' => 'unit',
                'attribute' => 'name',
                'allows_null' => false,
                'placeholder' => 'Select an unit'
            ],
            [
                'name' => 'quantity',
                'label' => 'Quantity',
                'type' => 'number',
            ],
            [
                'name' => 'note',
                'label' => 'Notes',
                'type' => 'textarea',
                'tab' => 'Profile'
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
}
