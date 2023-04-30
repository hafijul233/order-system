<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Customer;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class CompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CompanyCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation, InlineCreateOperation, FetchOperation;

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
        CRUD::addFilter(['name' => 'representative', 'type' => 'select2_multiple', 'label' => 'Representative'],
            Customer::all()->pluck('name', 'id')->toArray(),
            fn($value) => $this->crud->addClause('whereIn', 'representative_id', json_decode($value, true))
        );

        CRUD::addFilter(['name' => 'status', 'type' => 'select2_multiple', 'label' => 'Status'],
            Company::statusDropdown(),
            fn($value) => $this->crud->addClause('whereIn', 'status_id', json_decode($value, true))
        );

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
                'name' => 'representative_id',
                'label' => 'Representative',
                'type' => 'custom_html',
                'value' => fn(Company $company) => "<a class='text-info text-decoration-none' style='font-weight: 550 !important;' title='Customer' target='_blank' href='" . route('customer.show', $company->representative->id) . "'><i class='la la-user-check text-info'></i> {$company->representative->name}</a>",
            ],
            [
                'name' => 'email',
                'label' => 'Business Email',
                'type' => 'custom_html',
                'value' => fn(Company $company) => "<a class='text-dark' href='maiilto:{$company->email}'>{$company->email} " . (($company->email_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>"
            ],
            [
                'name' => 'phone',
                'label' => 'Business Phone',
                'type' => 'custom_html',
                'value' => fn(Company $company) => "<a class='text-dark' href='tel:{$company->phone}'>{$company->phone} " . (($company->phone_verified_at != null) ? "<i class='la la-check text-success font-weight-bold'></i>" : '') . "</a>"
            ],
            [
                'name' => 'status_id',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => fn(Company $company) => $company->status_html
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
                'type' => 'relationship',
                'ajax' => true,
                'data_source' => backpack_url('customer/fetch/customer'),
                'inline_create' => [
                    'entity' => 'customer',
                    'force_select' => true,
                    'modal_class' => 'modal-dialog modal-xl',
                    'modal_route' => route('customer-inline-create'), // InlineCreate::getInlineCreateModal()
                    'create_route' => route('customer-inline-create-save'), // InlineCreate::storeInlineCreate()
                    'add_button_label' => 'Add Representative'
                ],
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'designation',
                'label' => 'Designation',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'email',
                'label' => 'Business Email',
                'type' => 'email',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'phone',
                'label' => 'Business Phone',
                'tab' => 'Basic',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'status_id',
                'label' => 'Status',
                'type' => 'select2_from_array',
                'options' => Company::statusDropdown(),
                'default' => Company::defaultStatusId(),
                'allows_null' => false,
                'tab' => 'Basic'
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
            [
                'name' => 'newsletter_subscribed',
                'label' => 'Newsletter Subscribed?',
                'type' => 'boolean',
                'tab' => 'Promotion'
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

    protected function setupInlineCreateOperation()
    {
        //reset the previous fields
        $this->crud->setOperationSetting('fields', []);

        $request = request('main_form_fields', []);

        $form_fields = [];

        foreach ($request as $field) {
            if ($field['name'] == 'customer_id') {
                $form_fields[$field['name']] = $field['value'];
                break;
            }
        }

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'Name'
            ],
            [
                'name' => 'representative',
                'label' => 'Representative',
                'type' => 'relationship',
                'ajax' => true,
                'data_source' => backpack_url('customer/fetch/customer'),
                'default' => $form_fields['customer_id'] ?? null,
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'designation',
                'label' => 'Designation',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'email',
                'label' => 'Business Email',
                'type' => 'email',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'phone',
                'label' => 'Business Phone',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'status_id',
                'label' => 'Status',
                'type' => 'hidden',
                'default' => Company::defaultStatusId()
            ]
        ]);
    }

    /**
     * return a list of states with county condition
     * @return LengthAwarePaginator|Collection|JsonResponse|array
     * @link {app_url}/admin/company/fetch/representative
     *
     */
    protected function fetchCompany()
    {
        $request = request('form', []);

        foreach ($request as $field) {
            if (isset($field['name']) && $field['name'] == 'customer_id') {
                $representative = $field['value'];
                break;
            }
        }

        if (isset($representative)) {

            return $this->fetch([
                'model' => Company::class,
                'paginate' => false,
                'query' => fn($query) => $query->where('representative_id', '=', $representative),
            ]);
        }
        return [];
    }
}
