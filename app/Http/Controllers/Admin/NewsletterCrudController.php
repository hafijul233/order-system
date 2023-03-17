<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsletterRequest;
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

/**
 * Class NewsletterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class NewsletterCrudController extends CrudController
{
    use ListOperation, CreateOperation, UpdateOperation, DeleteOperation, ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Newsletter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/newsletter');
        CRUD::setEntityNameStrings('newsletter', 'newsletters');
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
                'name' => 'newsletterable',
                'label' => 'Subscriber',
                'type' => 'custom_html',
                'value' => function ($newsletter) {
                    if ($newsletter->newsletterable instanceof Customer) {
                        return "<a class='text-dark' title='Customer' target='_blank' href='" . route('customer.show', $newsletter->newsletterable->id) . "'><i class='la la-user text-info'></i> {$newsletter->newsletterable->name}</a>";
                    } elseif ($newsletter->newsletterable instanceof Company) {
                        return "<a class='text-dark' title='Company' target='_blank' href='" . route('company.show', $newsletter->newsletterable->id) . "'><i class='la la-building text-success'></i> {$newsletter->newsletterable->name}</a>";
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'custom_html',
                'value' => function ($newsletter) {
                    return "<a class='text-dark' href='mailto:{$newsletter->email}'>{$newsletter->email}</a>";
                }
            ],
            [
                'name' => 'attempted',
                'label' => 'Attempted',
                'type' => 'number'
            ],
            [
                'name' => 'subscribed',
                'label' => 'Subscribed?',
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
        CRUD::setValidation(NewsletterRequest::class);

        $newsletterable = [];

        Customer::all()->each(function ($customer) use (&$newsletterable) {
            $newsletterable[Customer::class . ':' . $customer->id] = $customer->name;
        });

        Company::all()->each(function ($company) use (&$newsletterable) {
            $newsletterable[Company::class . ':' . $company->id] = $company->name;
        });

        CRUD::addFields([
            [
                'name' => 'newsletterable',
                'label' => 'Subscriber',
                'type' => 'select_from_array',
                'options' => $newsletterable
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email'
            ],
            [
                'name' => 'attempted',
                'label' => 'Attempted',
                'type' => 'number',
                'default' => 1
            ],
            [
                'name' => 'subscribed',
                'label' => 'Subscribed?',
                'type' => 'boolean',
                'checked' => true
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
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
            ],
            [
                'name' => 'newsletterable',
                'label' => 'Subscriber',
                'type' => 'custom_html',
                'value' => function ($newsletter) {
                    if ($newsletter->newsletterable instanceof Customer) {
                        return "<a class='text-dark' title='Customer' target='_blank' href='" . route('customer.show', $newsletter->newsletterable->id) . "'><i class='la la-user text-info'></i> {$newsletter->newsletterable->name}</a>";
                    } elseif ($newsletter->newsletterable instanceof Company) {
                        return "<a class='text-dark' title='Company' target='_blank' href='" . route('company.show', $newsletter->newsletterable->id) . "'><i class='la la-building text-success'></i> {$newsletter->newsletterable->name}</a>";
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'custom_html',
                'value' => function ($newsletter) {
                    return "<a class='text-dark' href='mailto:{$newsletter->email}'>{$newsletter->email}</a>";
                }
            ],
            [
                'name' => 'attempted',
                'label' => 'Attempted',
                'type' => 'number'
            ],
            [
                'name' => 'subscribed',
                'label' => 'Subscribed?',
                'type' => 'boolean'
            ],
        ]);
    }
}
