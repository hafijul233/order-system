<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

/**
 * Class UnitCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UnitCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation, ReorderOperation, FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Unit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/unit');
        CRUD::setEntityNameStrings('unit', 'units');
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
                'label' => '#',
            ],
            [
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'conversion',
                'label' => 'Conversion',
                'type' => 'custom_html',
                'value' => function ($unit) {
                    return $this->unitConversion($unit);
                }
            ],
            [
                'name' => 'parent',
                'label' => 'Parent Order',
                'type' => 'custom_html',
                'value' => function($unit) {
                        return str_replace("> -", "",$this->unitParent($unit->parent, $unit->name));
                }
            ],
            [
                'name' => 'description',
                'label' => 'Description',
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled',
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
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
        CRUD::setValidation(UnitRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text'
            ],
            [
                'name' => 'conversion',
                'label' => 'Conversion',
                'type' => 'number'
            ],
            [
                'name' => 'parent',
                'label' => 'Parent',
                'type' => 'select2',
                'entity' => 'parent'
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea'
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

    /**
     * Define what happens when the Reorder operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupReorderOperation()
    {
        $this->crud->set('reorder.label', 'name');
        $this->crud->set('reorder.max_level', 5);
    }

    private function unitConversion($unit)
    {
        if ($unit->parent == null)
            return "-";

        return floatval($unit->conversion) . " {$unit->parent->name} per {$unit->name}";


    }

    private function unitParent($unit, string $name)
    {
        if ($unit == null)
            return "-";

        return "{$unit->name} > " . $this->unitParent($unit->parent, $unit->name);
    }

    protected function fetchUnit()
    {
        // $request = request('form', []);

        // $form_fields = [];

        // array_walk($request, function ($field) use (&$form_fields) {
        //     if(!in_array($field['name'], config('constant.form_excluded_fields')))
        //     $form_fields[$field['name']] = $field['value'];
        // });
        
        // dd($form_fields);

        return $this->fetch(Unit::class);
    }
}
