<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('code');
        CRUD::column('name');
        CRUD::column('category_id');
        CRUD::column('platform');
        CRUD::column('price');
        CRUD::column('short_description');
        CRUD::column('status');
        CRUD::column('updated_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        CRUD::addFields([
            //Basic
            [
                'name' => 'name',
                'label' => 'Title',
                'type' => 'text',
                'tab' => 'Basic'
            ],
            [
                'name' => 'code',
                'label' => 'Code OR SKU',
                'type' => 'text',
                'tab' => 'Basic'
            ],
            [
                'name' => 'category',
                'label' => 'Category',
                'type' => 'select2',
                'entity' => 'category',
                'tab' => 'Basic'
            ],
            [
                'name' => 'short_description',
                'label' => 'Short Description',
                'type' => 'textarea',
                'tab' => 'Basic'
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'ckeditor',
                'tab' => 'Basic'
            ],
            [
                'name' => 'platform',
                'label' => 'Platform',
                'type' => 'select_from_array',
                'options' => ['online' => 'Online', 'offline' => 'Offline', 'both' => 'Both'],
                'tab' => 'Basic'
            ],
            [
                'name' => 'price',
                'label' => 'Price',
                'type' => 'number',
                'tab' => 'Basic',
            ],
            //Inventory
            [
                'name' => 'inventory_enabled',
                'label' => 'Inventory Enabled',
                'type' => 'boolean',
                'tab' => 'Inventory'
            ],
            [
                'name' => 'weight',
                'label' => 'Weight',
                'type' => 'number',
                'tab' => 'Inventory',
            ],
            [
                'name' => 'default_quantity',
                'label' => 'Default Quantity',
                'type' => 'number',
                'tab' => 'Inventory',
            ],
            [
                'name' => 'cost',
                'label' => 'Cost',
                'type' => 'number',
                'tab' => 'Inventory',
            ],
            [
                'name' => 'reorder_level',
                'label' => 'Reorder Level',
                'type' => 'number',
                'tab' => 'Inventory',
            ],
            //Detail
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'select_from_array',
                'options' => ['normal' => 'Normal', 'bundle' => 'Bundle/Combo'],
                'tab' => 'Detail'
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select_from_array',
                'tab' => 'Detail',
                'options' => ['active' => 'Active']
            ],
            [
                'name' => 'block_reason',
                'label' => 'Suspend/Block Reason',
                'type' => 'textarea',
                'tab' => 'Detail',
            ],
            [
                'name' => 'note',
                'label' => 'Notes',
                'type' => 'textarea',
                'tab' => 'Detail',
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
