<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NotificationRequest;
use App\Models\Customer;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NotificationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class NotificationCrudController extends CrudController
{
    use ListOperation, ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Notification::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/notification');
        CRUD::setEntityNameStrings('notification', 'notifications');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::getModel()->newQuery()->where([
            'notifiable_type' => User::class,
            'notifiable_id' => backpack_user()->id,
        ]);

        CRUD::addColumns([
            [
                'name' => 'type',
                'label' => 'Type'
            ],
            [
                'name' => 'notifiable',
                'label' => 'Notification To',
                'type' => 'custom_html',
                'value' => function ($notification) {
                    if ($notification->notifiable instanceof Customer) {
                        return "<a class='text-dark' title='Customer' target='_blank' href='" . route('customer.show', $notification->notifiable->id) . "'><i class='la la-user text-info'></i> {$notification->notifiable->name}</a>";
                    } elseif ($notification->notifiable instanceof User) {
                        return "<a class='text-dark' title='User' target='_blank' href='" . route('user.show', $notification->notifiable->id) . "'><i class='la la-user-cog text-success'></i> {$notification->notifiable->name}</a>";
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'name' => 'data',
                'label' => 'Message',
                'type' => 'custom_html',
                'value' => function ($notification) {
                    return $notification->data;
                    /*if ($notification->notifiable instanceof Customer) {
                        return "<a class='text-dark' title='Customer' target='_blank' href='" . route('customer.show', $notification->notifiable->id) . "'><i class='la la-user text-info'></i> {$notification->notifiable->name}</a>";
                    } elseif ($notification->notifiable instanceof User) {
                        return "<a class='text-dark' title='User' target='_blank' href='" . route('user.show', $notification->notifiable->id) . "'><i class='la la-user-cog text-success'></i> {$notification->notifiable->name}</a>";
                    } else {
                        return '-';
                    }*/
                }
            ],
            [
                'name' => 'read_at',
                'label' => 'Checked At',
                'type' => 'datetime',
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
                'type' => 'datetime',
            ],

        ]);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(NotificationRequest::class);

        CRUD::field('type');
        CRUD::field('notifiable_type');
        CRUD::field('notifiable_id');
        CRUD::field('data');
        CRUD::field('read_at');

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
}
