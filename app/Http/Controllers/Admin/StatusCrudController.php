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
        CRUD::column('id')->label('#');
        CRUD::addColumn([
            'name' => 'name',
            'type' => 'custom_html',
            'label' => 'Name',
            'value' => function ($status) {
                return "<span><i class='{$status->icon}'></i> $status->name</span>";
            }
        ]);
        CRUD::column('code');
        CRUD::column('parent_id');
        CRUD::column('is_default')->type('boolean')->label('Default?');
        CRUD::column('enabled')->type('boolean');
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
        CRUD::setValidation(StatusRequest::class);

        CRUD::addField([
            'name' => 'model',
            'label' => 'Model',
            'type' => 'select2_from_array',
            'options' => [
                Customer::class => 'Customer',
                AddressBook::class => 'Address Book',
                Company::class => 'Company',
                Category::class => 'Category',
                Order::class => 'Order',
                Payment::class => 'Payment',
                Product::class => 'Product',
                Stock::class => 'Stock',
                Email::class => 'Email',
                NewsLetter::class => 'NewsLetter',
                Campaign::class => 'Campaign',
                Coupon::class => 'Coupon',
                Banner::class => 'Banner',
                Page::class => 'Page',
                Template::class => 'Template',
                Task::class => 'Task',
            ]
        ]);
        CRUD::field('name');
        CRUD::field('code');
        CRUD::addField([
            'label' => "Icon",
            'name' => 'icon',
            'type' => 'icon_picker',
            'iconset' => 'lineawesome' // options: fontawesome, lineawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
        ]);
        CRUD::field('icon')->type('icon_picker');
        CRUD::field('description');
        CRUD::field('enabled')->type('boolean');
        CRUD::field('is_default')->type('boolean');
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
        // model attribute to be shown on draggable items
        $this->crud->set('reorder.label', 'name');
        $this->crud->allowAccess('revisions');
    }
}
