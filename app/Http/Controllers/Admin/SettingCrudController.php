<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Config;

class SettingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup()
    {
        CRUD::setModel("App\Models\Setting");
        CRUD::setEntityNameStrings(trans('settings.setting_singular'), trans('settings.setting_plural'));
        CRUD::setRoute(backpack_url(config('backpack.settings.route')));
    }

    public function setupListOperation()
    {
        CRUD::setOperationSetting('lineButtonsAsDropdown', false);
        
        // only show settings which are marked as active
        CRUD::addClause('where', 'active', 1);

        // columns to show in the table view
        CRUD::setColumns([
            [
                'name'  => 'name',
                'label' => trans('settings.name'),
            ],
            [
                'name'  => 'value',
                'label' => trans('settings.value'),
            ],
            [
                'name'  => 'description',
                'label' => trans('settings.description'),
            ],
        ]);
    }

    public function setupUpdateOperation()
    {
        CRUD::addField([
            'name'       => 'name',
            'label'      => trans('settings.name'),
            'type'       => 'text',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

        CRUD::addField(json_decode(CRUD::getCurrentEntry()->field, true));
    }
}
