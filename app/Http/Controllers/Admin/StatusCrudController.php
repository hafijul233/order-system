<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StatusRequest;
use App\Models\AddressBook;
use App\Models\Banner;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Company;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Email;
use App\Models\Newsletter;
use App\Models\Order;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Task;
use App\Models\Template;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StatusCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class StatusCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    private array $models;

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Status::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/status');
        CRUD::setEntityNameStrings('status', 'statuses');
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
                'name' => 'model',
                'type' => 'select2',
                'label' => 'Model'
            ],
            Status::MODELS,
            function ($value) {
                $this->crud->addClause('where', 'model', '=', $value);
            });

        CRUD::column('id')->label('#');
        CRUD::addColumn([
            'name' => 'icon',
            'type' => 'custom_html',
            'label' => 'Icon',
            'value' => function ($status) {
                return "<i class='{$status->icon}'></i>";
            }
        ]);
        CRUD::column('name');
        CRUD::addColumn([
            'name' => 'color',
            'type' => 'custom_html',
            'label' => 'Color',
            'value' => function ($status) {
                return "<div style='background-color: {$status->color}; width: 1rem; height: 1rem; border-radius: 50%;'></div>";
            }
        ]);
        CRUD::column('code');
        CRUD::column('is_default')->type('boolean')->label('Default?');
        CRUD::column('enabled')->type('boolean');
        CRUD::column('created_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(StatusRequest::class);

        CRUD::addFields([
            [
                'name' => 'model',
                'label' => 'Model',
                'type' => 'select2_from_array',
                'options' => Status::MODELS
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text'
            ],
            [
                'name' => 'code',
                'label' => 'Code',
                'type' => 'text'
            ],
            [
                'label' => "Icon",
                'name' => 'icon',
                'type' => 'icon_picker',
                'iconset' => 'fontawesome'
            ], [
                'label' => "Color",
                'name' => 'color',
                'type' => 'color_picker'
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea'
            ],
            [
                'name' => 'enabled',
                'label' => 'enabled?',
                'type' => 'boolean'
            ],
            [
                'name' => 'is_default',
                'label' => 'is Default?',
                'type' => 'boolean'
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

    protected function setupReorderOperation()
    {
        $this->crud->set('reorder.label', 'name');
        $this->crud->set('reorder.max_level', 0);
    }
}
