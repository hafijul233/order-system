<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Company::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/company');
        CRUD::setEntityNameStrings('company', 'companies');
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
                'name' => 'status',
                'type' => 'dropdown',
                'label' => 'Status'
            ],
            Company::STATUSES,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'status', '=', $value);
            });

        CRUD::addFilter(
            [
                'name' => 'created_at',
                'type' => 'date_range',
                'label' => 'Created'
            ],
            false,
            function ($value) { // if the filter is active
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from . ' 00:00:00');
                $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            });

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
                'name' => 'representative',
                'label' => 'Representative'
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'custom_html',
                'value' => function ($company) {
                    return "<a class='text-dark' href='maiilto:{$company->email}'>{$company->email} " . (($company->email_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>";
                }
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'type' => 'custom_html',
                'value' => function ($company) {
                    return "<a class='text-dark' href='tel:{$company->phone}'>{$company->phone} " . (($company->phone_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>";
                }
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => function ($company) {
                    return match ($company->status) {
                        'active' => "<span class='text-success'><i class='la la-check'></i> " . Company::STATUSES[$company->status] . "</span>",
                        'suspended' => "<span class='text-warning'><i class='la la-warning'></i> " . Company::STATUSES[$company->status] . "</span>",
                        'banned' => "<span class='text-danger'><i class='la la-times'></i> " . Company::STATUSES[$company->status] . "</span>",
                    };
                }
            ]
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
        CRUD::setValidation(CompanyRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'Name',
                'tab' => 'Basic',
            ],
            [
                'name' => 'representative',
                'label' => 'Representative',
                'tab' => 'Basic',
            ],
            [
                'name' => 'designation',
                'label' => 'Designation',
                'tab' => 'Basic',
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email',
                'tab' => 'Basic',
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'tab' => 'Basic',
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select_from_array',
                'options' => Company::STATUSES,
                'allows_null' => false,
                'tab' => 'Detail'
            ],
            [
                'name' => 'block_reason',
                'label' => 'Suspend/Banned Reason',
                'type' => 'textarea',
                'tab' => 'Detail'
            ],
            [
                'name' => 'note',
                'label' => 'Notes',
                'type' => 'textarea',
                'tab' => 'Detail'
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
