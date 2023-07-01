<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuditRequest;
use App\Models\Customer;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AuditCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AuditCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Audit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/audit');
        CRUD::setEntityNameStrings('activity log', 'activity logs');
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
                'name' => 'user',
                'label' => 'User',
                'type' => 'custom_html',
                'value' => function ($audit) {
                    return $this->auditUser($audit->user);
                }
            ],
            [
                'name' => 'event',
                'label' => 'Event',
                'type' => 'custom_html',
                'value' => function ($audit) {
                    return $this->auditEvent($audit->event);
                }
            ],
            [
                'name' => 'ip_address',
                'label' => 'IP Address',
            ],
            [
                'name' => 'auditable',
                'label' => 'Audit',
                'type' => 'custom_html',
                'value' => function ($audit) {
                    if ($audit->auditable == null)
                        return '-';

                    $class = strtolower(class_basename($audit->auditable));

                    return "<a class='font-weight-bold text-primary' href='" . route($class . '.show', $audit->auditable->id) . "'>{$audit->auditable_type}:{$audit->auditable_id}</a>";
                }
            ],
            [
                'name' => 'url',
                'label' => 'Url',
                'type' => 'url'
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
                'type' => 'datetime'
            ],

        ]);
    }

    public function setupShowOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'id',
                'label' => 'ID'
            ],
            [
                'name' => 'user',
                'label' => 'User',
                'type' => 'custom_html',
                'value' => function ($audit) {
                    return $this->auditUser($audit->user);
                }
            ],
            [
                'name' => 'event',
                'label' => 'Event',
                'type' => 'custom_html',
                'value' => function ($audit) {
                    return $this->auditEvent($audit->event);
                }
            ],
            [
                'name' => 'ip_address',
                'label' => 'IP Address',
            ],
            [
                'name' => 'auditable',
                'label' => 'Audits',
                'type' => 'custom_html',
                'value' => function ($audit) {
                    if ($audit->auditable == null)
                        return '-';

                    $class = strtolower(class_basename($audit->auditable));

                    return "<a class='font-weight-bold text-primary' href='" . route($class . '.show', $audit->auditable->id) . "'>{$audit->auditable_type}:{$audit->auditable_id}</a>";
                }
            ],
            [
                'name' => 'url',
                'label' => 'Url',
                'type' => 'url'
            ],
            [
                'name' => 'user_agent',
                'label' => 'Platform',
            ],
            [
                'name' => 'old_values',
                'label' => 'Old Values',
                'type' => 'json'
            ],
            [
                'name' => 'new_values',
                'label' => 'New Values',
                'type' => 'json'
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
                'type' => 'datetime'
            ],

        ]);
    }

    private function auditUser($user = null): string
    {
        if ($user == null)
            return '-';

        return match (get_class($user)) {
            User::class => "<a class='font-weight-bold text-dark' href='" . route('user.showDetailsRow', $user->id) . "'>{$user->name}</a>",
            Customer::class => "<a class='font-weight-bold text-dark' href='" . route('customer.show', $user->id) . "'>{$user->name}</a>",
            default => '-'
        };
    }

    private function auditEvent($event = null): string
    {
        return match ($event) {
            'created' => "<span class='badge badge-success'>Created</span>",
            'updated' => "<span class='badge badge-warning'>Updated</span>",
            'deleted' => "<span class='badge badge-danger'>Deleted</span>",
            'restored' => "<span class='badge badge-primary'>Restored</span>",
            default => "<span class='badge badge-info'>Unknown</span>"
        };
    }
}
