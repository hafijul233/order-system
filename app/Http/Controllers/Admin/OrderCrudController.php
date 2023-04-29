<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Config;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addFilter(['name' => 'platform', 'type' => 'select2_multiple', 'label' => 'Platform'],
            Order::PLATFORMS,
            fn($value) => $this->crud->addClause('where', 'platform', '=', $value)
        );

        CRUD::addFilter(['name' => 'delivery', 'type' => 'select2_multiple', 'label' => 'Delivery'],
            Order::DELIVERIES,
            fn($value) => $this->crud->addClause('where', 'delivery', '=', $value)
        );

        CRUD::addFilter(['name' => 'status', 'type' => 'select2_multiple', 'label' => 'Status'],
            Order::statusDropdown(),
            fn($value) => $this->crud->addClause('whereIn', 'status_id', json_decode($value, true))
        );

        CRUD::addFilter(['type' => 'text', 'name' => 'phone', 'label' => 'Phone'],
            false,
            fn($value) => $this->crud->addClause('where', 'phone', 'like', "%{$value}}")
        );

        CRUD::addFilter([
            'name' => 'total_amount',
            'type' => 'range',
            'label' => 'Order Total Price',
            'label_from' => 'min',
            'label_to' => 'max'
        ],
            false,
            function ($value) { // if the filter is active
                $range = json_decode($value);
                if ($range->from) {
                    $this->crud->addClause('where', 'total_amount', '>=', (float)$range->from);
                }
                if ($range->to) {
                    $this->crud->addClause('where', 'total_amount', '<=', (float)$range->to);
                }
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
                'type' => 'custom_html',
                'value' => function (Order $order) {
                    return setting('order_prefix', '#')
                        . str_pad($order->id, (int)setting('order_number_length', 8), "0", STR_PAD_LEFT);
                }
            ],
            [
                'name' => 'platform',
                'label' => 'Platform',
                'type' => 'custom_html',
                'value' => fn(Order $order) => $order->type_html
            ],
            [
                'name' => 'name',
                'label' => 'Name',
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'type' => 'custom_html',
                'value' => fn(Order $order) => "<a class='text-dark' href='tel:{$order->phone}'>{$order->phone}</a>"
            ],
            [
                'name' => 'total_amount',
                'label' => 'Total',
                'type' => 'number'
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'custom_html',
                'value' => fn(Order $order) => $order->status_html
            ],
            [
                'name' => 'ordered_at',
                'type' => 'datetime',
                'label' => 'Ordered'
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
        CRUD::setValidation(OrderRequest::class);

        $scripts = Config::get('backpack.base.scripts');

        $scripts[] = 'packages/backpack/base/js/order.js';

        Config::set('backpack.base.scripts', $scripts);

        CRUD::addFields([
            [
                'name' => 'platform',
                'label' => 'platform',
                'type' => 'hidden',
                'options' => Order::PLATFORMS,
                'tab' => 'Basic',
                'default' => 'offline'
            ],
            [
                'name' => 'orderable',
                'label' => 'Ordered From',
                'type' => 'relationship',
                'allows_null' => false,
                'ajax' => true,
                'morphOptions' => [
                    [Customer::class,],
                    [Company::class,]
                ],
                'tab' => 'Basic',
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
                'tab' => 'Basic',
                'attributes' => [
                    'placeholder' => 'Select Customer/Company First',
                    'readonly' => 'readonly',
                    'id' => 'orderable_name'
                ]
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'text',
                'tab' => 'Basic',
                'attributes' => [
                    'placeholder' => 'Select Customer/Company First',
                    'readonly' => 'readonly',
                    'id' => 'orderable_email'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'phone',
                'label' => 'Phone',
                'type' => 'text',
                'tab' => 'Basic',
                'attributes' => [
                    'placeholder' => 'Select Customer/Company First',
                    'readonly' => 'readonly',
                    'id' => 'orderable_phone'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'status_id',
                'label' => 'Status',
                'type' => 'select2_from_array',
                'options' => Order::statusDropdown(),
                'default' => Order::defaultStatusId(),
                'tab' => 'Basic',
            ],
            [
                'name' => 'address_book_id',
                'label' => 'Address',
                'type' => 'select2',
                'entity' => 'addressBook',
                'attribute' => 'full_address_dropdown',
                'ajax' => true,
                'inline_create' => true,
                'tab' => 'Delivery',

            ],
            [
                'name' => 'subtotal',
                'label' => 'subtotal',
                'type' => 'number',
                'tab' => 'Order',
            ],
            [
                'name' => 'tax',
                'label' => 'tax',
                'type' => 'number',
                'tab' => 'Order',
            ],
            [
                'name' => 'discount',
                'label' => 'discount',
                'type' => 'number',
                'tab' => 'Order',
            ],
            /*            [
                            'name' => 'total_item',
                            'label' => 'total_item',
                            'type' => 'number',
                            'tab' => 'Order',
                        ],*/
            [
                'name' => 'delivery_charge',
                'label' => 'delivery_charge',
                'type' => 'number',
                'tab' => 'Order',
            ],
            [
                'name' => 'total_amount',
                'label' => 'total_amount',
                'type' => 'number',
                'tab' => 'Order'
            ],
            [
                'name' => 'assignee_id',
                'label' => 'assignee_id',
                'type' => 'select2',
                'entity' => 'assignee',
                'attribute' => 'name',
                'default' => backpack_user()->id,
                'tab' => 'Order'
            ],
            [
                'name' => 'delivery',
                'label' => 'delivery',
                'type' => 'select2_from_array',
                'options' => Order::DELIVERIES,
                'tab' => 'Delivery',
            ],
            [
                'name' => 'delivery_comment',
                'label' => 'delivery_comment',
                'type' => 'textarea',
                'tab' => 'Delivery',
            ],
            [
                'name' => 'ip_address',
                'label' => 'ip_address',
                'type' => 'hidden',
                'default' => request()->ip(),
            ],
            [
                'name' => 'user_agent',
                'label' => 'user_agent',
                'type' => 'hidden',
                'default' => request()->userAgent(),
            ],
            [
                'name' => 'priority',
                'label' => 'priority',
                'type' => 'select2_from_array',
                'options' => Order::PRIORITIES,
                'default' => 'medium',
                'tab' => 'Delivery'
            ],
            [
                'name' => 'block_reason',
                'label' => 'block_reason',
                'type' => 'textarea',
                'tab' => 'Delivery',
            ],
            [
                'name' => 'note',
                'label' => 'note',
                'type' => 'textarea',
                'tab' => 'Delivery',
            ],
            [
                'name' => 'ordered_at',
                'label' => 'ordered_at',
                'type' => 'datetime',
                'tab' => 'Order',
            ],
            [
                'name' => 'delivered_at',
                'label' => 'delivered_at',
                'type' => 'datetime',
                'tab' => 'Delivery',
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
