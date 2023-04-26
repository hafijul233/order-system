<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BannerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BannerCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Banner::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/banner');
        CRUD::setEntityNameStrings('banner', 'banners');
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
                'name' => 'image',
                'label' => 'Image',
                'type' => 'image',
            ],
            [
                'name' => 'lft',
                'label' => 'Position',
                'type' => 'text',
                'value' => fn(Banner $banner) => $banner->lft / 2
            ],
            [
                'name' => 'link',
                'label' => 'Link',
                'type' => 'custom_html',
                'value' => fn(Banner $banner) => "<a href='{$banner->link}' target='_blank' class='text-info font-weight-bold'><i class='la la-link'></i>{$banner->link_text}</a>",
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled?',
                'type' => 'boolean',
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
        CRUD::setValidation(BannerRequest::class);

        CRUD::addFields([
            [
                'name' => 'image',
                'label' => 'Image',
                'type' => 'image',
                'crop' => true,
                'fake' => true,
            ],
            [
                'name' => 'message',
                'label' => 'Message',
                'type' => 'ckeditor',
            ],
            [
                'name' => 'link',
                'label' => 'Link',
                'type' => 'url',
                'hint' => 'N.B: If link set empty will disable link from that slide'
            ],
            [
                'name' => 'link_text',
                'label' => 'Link Text',
                'type' => 'text',
            ],
            [
                'name' => 'enabled',
                'label' => 'Enabled?',
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

    protected function setupReorderOperation()
    {
        $this->crud->set('reorder.label', 'link_text');
        $this->crud->set('reorder.max_level', 1);
    }
}
