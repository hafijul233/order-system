<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

/**
 * Class AttributeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AttributeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Attribute::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/attribute');
        CRUD::setEntityNameStrings('attribute', 'attributes');
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
                'type' => 'text'
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'select_from_array',
                'options' => config('constant.attribute_type')
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled',
                'type' => 'boolean'
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
        CRUD::setValidation(AttributeRequest::class);

        
        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text'
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'select2_from_array',
                'default' => 'text',
                'options' => config('constant.attribute_type')
            ],
            [
                'name' => 'unit',
                'label' => 'Minimum Unit',
                'type' => 'relationship',
                'entity' => 'unit',
                'attribute' => 'name',
                'options' => function ($query) {
                    return $query->whereNull('parent_id')->get();
                }
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled',
                'type' => 'boolean'
            ],
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

    protected function fetchAttribute()
    {
        return $this->fetch([
            'model' => Attribute::class,
            'query' => function($model) {
                return $model->where('enabled', '=', true);
            }
        ]);
    }
}
