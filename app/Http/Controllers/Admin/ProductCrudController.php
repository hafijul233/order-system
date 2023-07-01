<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;
    use FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings(setting('item_label', 'product'), \Str::plural(setting('item_label', 'product')));
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
                'label' => '#'
            ],
            [
                'name' => 'code',
                'label' => 'Code'
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'closure',
                'function' => fn (Product $product) => $product->name,
            ],
            [
                'name' => 'category_id',
                'label' => 'Category'
            ],
            [
                'name' => 'platform',
                'label' => 'Platform',
                'type' => 'custom_html',
                'value' => fn (Product $product) => $product->platform_html,
            ],
            [
                'name' => 'price',
                'label' => 'Price'
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => fn (Product $product) => $product->status_html,
            ],
            [
                'name' => 'updated_at',
                'label' => 'Last updated',
                'type' => 'datetime'
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
        CRUD::setValidation(ProductRequest::class);

        Widget::add()->type('script')->content('js/pages/product.js');

        CRUD::addFields([
            //Basic
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'select2_from_array',
                'options' => Product::TYPES,
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'code',
                'label' => 'Code OR SKU',
                'type' => 'text',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'name',
                'label' => 'Name',
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
                'name' => 'cost',
                'label' => 'Cost',
                'type' => 'number',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'price',
                'label' => 'Price',
                'type' => 'number',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                'attributes' => [
                    'placeholder' => 'Selling Price per Unit'
                ]
            ],
            [
                'name' => 'platform',
                'label' => 'Platform',
                'type' => 'hidden',
                'default' => 'both',
                'tab' => 'Basic'
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select2_from_array',
                'tab' => 'Basic',
                'options' => Product::statusDropdown(),
                'default' => Product::defaultStatusId(),
                'allows_null' => false,
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            //Media
            [
                'name' => 'cover_photo',
                'type' => 'browse',
                'label' => 'Main Cover Photo',
                'allows_null' => false,
                'tab' => 'Media'
            ],
            [
                'name' => 'additional_photo',
                'type' => 'browse_multiple',
                'label' => 'Additional Cover Photo',
                'allows_null' => false,
                'tab' => 'Media'
            ],
            //Attribute
            [
                'name' => 'attributes',
                'label' => 'Attributes',
                'type' => 'relationship',
                'tab' => 'Attribute',
                'entity' => 'attributes',
                'new_item_label' => 'Add Attribute',
                'pivotSelect' => [
                    'name' => 'attribute_id',
                    'label' => 'Attribute',
                    'type' => 'select2_from_ajax',
                    'ajax' => true,
                    'data_source' => backpack_url('attribute/fetch/attribute'),
                    'minimum_input_length' => 0,
                    'method' => 'POST',
                    'placeholder' => "Select an attribute",
                    'allows_null' => false,
                    'wrapper' => [
                        'class' => 'form-group col-md-6',
                    ],
                ],
                'subfields' => [
                    [
                        'name' => 'value',
                        'type' => 'text',
                        'label' => 'Value',
                        'wrapper' => [
                            'class' => 'form-group col-md-3',
                        ],
                    ],
                    [
                        'name' => 'unit_id',
                        'label' => 'Unit',
                        'type' => 'select2_from_ajax',
                        'ajax' => true,
                        'data_source' => backpack_url('unit/fetch/unit'),
                        'minimum_input_length' => 0,
                        'method' => 'POST',
                        'placeholder' => "Select an unit",
                        'wrapper' => [
                            'class' => 'form-group col-md-3',
                        ],
                        'dependencies' => ['attributes'],
                        'include_all_form_fields' => true,
                    ]
                ],
            ],
            //Detail
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
            ],
            //Inventory
            [
                'name' => 'inventory_enabled',
                'label' => 'Inventory Enabled',
                'type' => 'boolean',
                'tab' => 'Inventory'
            ],
            [
                'name' => 'default_quantity',
                'label' => 'Default Quantity',
                'type' => 'number',
                'tab' => 'Inventory',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'defaultUnit',
                'label' => 'Default Unit',
                'type' => 'relationship',
                'tab' => 'Inventory',
                'options' => function ($query) {
                    return $query->whereNull('parent_id')->get();
                },
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'units',
                'label' => 'Avaliable Units',
                'type' => 'relationship',
                'tab' => 'Inventory',
                'entity' => 'units',
                'attribute' => 'name',
                'options' => function ($query) {
                    return $query->whereNull('parent_id')->get();
                }
            ],
            [
                'name' => 'weight',
                'label' => 'Weight',
                'type' => 'number',
                'tab' => 'Inventory',
            ],
            [
                'name' => 'reorder_level',
                'label' => 'Reorder Level',
                'type' => 'number',
                'tab' => 'Inventory',
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
     * @see  https://backpackforlaravel.com/docs/crud-operation-show-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => '#'
            ],
            [
                'name' => 'code',
                'label' => 'Code'
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'closure',
                'function' => fn (Product $product) => $product->name,
            ],
            [
                'name' => 'category_id',
                'label' => 'Category'
            ],
            [
                'name' => 'platform',
                'label' => 'Platform',
                'type' => 'custom_html',
                'value' => fn (Product $product) => $product->platform_html,
            ],
            [
                'name' => 'price',
                'label' => 'Price'
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => fn (Product $product) => $product->status_html,
            ],
            [
                'name' => 'updated_at',
                'label' => 'Last updated',
                'type' => 'datetime'
            ],
        ]);

        if(setting('display_activity_log') == '1') {
            Widget::add([
                'type' => 'audit',
                'section' => 'after_content',
                'wrapper' => ['class' => 'col-md-12 px-0'],
                'header' => "<h5 class='card-title mb-0'>" . setting('item_label', 'Product') ."Activity Logs</h5>",
                'crud' => $this->crud,
            ]);
        }
    }

    protected function fetchProduct()
    {
        return $this->fetch(Product::class);

    }
}
