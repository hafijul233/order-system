<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BrandRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class BrandCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BrandCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Brand::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/brand');
        CRUD::setEntityNameStrings('brand', 'brands');
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
        CRUD::column('image');
        CRUD::column('name');
        CRUD::column('slug');
        CRUD::column('status_id');
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
        CRUD::setValidation(BrandRequest::class);

        CRUD::field('name');
        CRUD::field('slug')->type('slug')->target('name');
        CRUD::field('description');
        CRUD::field('image')->type('browse');
        CRUD::field('status_id');

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

        /**
     * Define what happens when the Show operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-show-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('id')->label('#');
        CRUD::column('image');
        CRUD::column('name');
        CRUD::column('slug');
        CRUD::column('status_id');
        CRUD::column('updated_at');

        if(setting('display_activity_log') == '1') {
            Widget::add([
                'type' => 'audit',
                'section' => 'after_content',
                'wrapper' => ['class' => 'col-md-12 px-0'],
                'header' => "<h5 class='card-title mb-0'>BrandActivity Logs</h5>",
                'crud' => $this->crud,
            ]);
        }
    }
}
