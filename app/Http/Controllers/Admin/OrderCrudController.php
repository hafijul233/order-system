<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
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
        CRUD::setEntityNameStrings(setting('order_label', 'order'), \Str::plural(setting('order_label', 'order')));
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addClause('where', 'type', '=', 'order');

        CRUD::addFilter(['name' => 'platform', 'type' => 'select2_multiple', 'label' => 'Platform'],
            config('constant.platforms'),
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
                'name' => 'total_item',
                'label' => 'Items',
                'type' => 'number',
                'decimals'      => 2,
            ],
            [
                'name' => 'total_amount',
                'label' => 'Total',
                'type' => 'number',
                'decimals'      => 2,
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
            //Basic
            [
                'name' => 'platform',
                'label' => 'platform',
                'type' => 'hidden',
                'tab' => 'Basic',
                'value' => 'office'
            ],
            [
                'name' => 'customer_id',
                'label' => 'Customer',
                'type' => 'relationship',
                'entity' => 'customer',
                'tab' => 'Basic',
                'allows_null' => false,
                'data_source' => backpack_url('customer/fetch/customer'),
                'minimum_input_length' => 0,
                'placeholder' => "Select a customer",
                'include_all_form_fields' => true,
                'method' => 'POST',
                'attributes' => [
                    'id' => 'customer_id'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6 mb-md-0 mb-3'
                ],
                'inline_create' => [
                    'entity' => 'customer',
                    'force_select' => true,
                    'modal_class' => 'modal-dialog modal-xl',
                    'modal_route' => route('customer-inline-create'), // InlineCreate::getInlineCreateModal()
                    'create_route' => route('customer-inline-create-save'), // InlineCreate::storeInlineCreate()
                    'add_button_label' => 'Add Customer',
                ],
            ],
            [
                'name' => 'company_id',
                'label' => 'Company',
                'type' => 'relationship',
                'entity' => 'company',
                'tab' => 'Basic',
                'ajax' => true,
                'hint' => 'N.B: Select company for bulk order only',
                'data_source' => backpack_url('company/fetch/company'),
                'minimum_input_length' => 0,
                'placeholder' => "Select a company",
                'include_all_form_fields' => true,
                'method' => 'POST',
                'attributes' => [
                    'id' => 'company_id'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6 mb-md-0 mb-3'
                ],
                'inline_create' => [
                    'entity' => 'company',
                    'force_select' => true,
                    'modal_class' => 'modal-dialog modal-xl',
                    'modal_route' => route('company-inline-create'), // InlineCreate::getInlineCreateModal()
                    'create_route' => route('company-inline-create-save'), // InlineCreate::storeInlineCreate()
                    'add_button_label' => 'Add Company',
                    'include_main_form_fields' => ['customer_id'],
                ],
            ],
            [
                'name' => 'address_book_id',
                'label' => 'Address',
                'type' => 'relationship',
                'entity' => 'addressBook',
                'attribute' => 'full_address_dropdown',
                'data_source' => backpack_url('address-book/fetch/address-book'),
                'minimum_input_length' => 0,
                'placeholder' => "Select a address",
                'ajax' => true,
                'method' => 'POST',
                'include_all_form_fields' => true,
                'tab' => 'Basic',
                'inline_create' => [
                    'entity' => 'addressBook',
                    'force_select' => true,
                    'modal_class' => 'modal-dialog modal-xl',
                    'modal_route' => route('address-book-inline-create'), // InlineCreate::getInlineCreateModal()
                    'create_route' => route('address-book-inline-create-save'), // InlineCreate::storeInlineCreate()
                    'add_button_label' => 'Add Address',
                    'include_main_form_fields' => ['customer_id', 'company_id'],
                ],

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
                'options' => OrderItem::statusDropdown(),
                'default' => OrderItem::defaultStatusId(),
                'tab' => 'Basic',
            ],
            [
                'name' => 'ip_address',
                'label' => 'ip_address',
                'type' => 'hidden',
                'default' => request()->ip(),
                'tab' => 'Basic'
            ],
            [
                'name' => 'user_agent',
                'label' => 'user_agent',
                'type' => 'hidden',
                'default' => request()->userAgent(),
                'tab' => 'Basic'
            ],
            //Items
            [
                'name' => 'orderItems',
                'label' => ucfirst(\Str::plural(setting('item_label', 'Item'))),
                'type' => 'relationship',
                'tab' => 'Item',
                'new_item_label' => 'Add ' . ucfirst(\Str::plural(setting('item_label', 'Item'))),
                'subfields' => [
                    [
                        'name' => 'product_id',
                        'label' => setting('item_label', 'Product'),
                        'type' => 'select2_from_ajax',
                        'ajax' => true,
                        'data_source' => backpack_url('product/fetch/product'),
                        'minimum_input_length' => 0,
                        'method' => 'POST',
                        'placeholder' => "Select a " . strtolower(setting('item_label', 'Product')),
                        'attributes' => [
                          'class' => 'form-control custom-select product-select',
                          'onchange' => 'loadProductData(this, this.value);'
                        ],
                        'wrapper' => [
                            'class' => 'form-group col-md-5',
                        ],
                    ],
                    [
                        'name' => 'name',
                        'type' => 'hidden',
                        'label' => 'Name',
                        'attributes' => [
                            'class' => 'form-control product-name'
                        ]
                    ],
                    [
                        'name' => 'price',
                        'type' => 'number',
                        'label' => 'Price',
                        'default' => "0.00",
                        'decimals'      => 2,
                        'wrapper' => [
                            'class' => 'form-group col-md-2',
                        ],
                        'attributes' => [
                            'min' => '0',
                            'step' => '0.01',
                            'class' => 'form-control product-unit-price text-right',
                            'onblur' => 'calculateOrderSummary()'
                        ]
                    ],
                    [
                        'name' => 'quantity',
                        'type' => 'number',
                        'default' => "0.00",
                        'wrapper' => [
                            'class' => 'form-group col-md-1',
                        ],
                        'attributes' => [
                            'min' => '0',
                            'step' => 'any',
                            'class' => 'form-control product-quantity text-right',
                            'onblur' => 'calculateOrderSummary()'
                        ]
                    ],
                    [
                        'name' => 'subtotal',
                        'label' => 'Bill',
                        'type' => 'number',
                        'default' => "0.00",
                        'decimals'      => 2,
                        'wrapper' => [
                            'class' => 'form-group col-md-2',
                        ],
                        'attributes' => [
                            'min' => '0',
                            'step' => '0.01',
                            'readonly' => 'readonly',
                            'class' => 'form-control product-subtotal text-right'
                        ]
                    ],
                    [
                        'name' => 'status_id',
                        'label' => 'Status',
                        'type' => 'select_from_array',
                        'options' => OrderItem::statusDropdown(),
                        'default' => Order::defaultStatusId(),
                        'wrapper' => [
                            'class' => 'form-group col-md-2',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'subtotal',
                'label' => 'Sub Total',
                'type' => 'number',
                'tab' => 'Item',
                'default' => "0.00",
                'decimals'      => 2,
                'attributes' => [
                    'id' => 'item-subtotal',
                    'readonly' => 'readonly',
                    'min' => '0',
                    'step' => '1',
                ]
            ],
            [
                'name' => 'tax',
                'label' => 'Sales Tax',
                'type' => 'number',
                'tab' => 'Item',
                'default' => "0.00",
                'decimals'      => 2,
                'attributes' => [
                    'id' => 'item-tax'
                ]
            ],
            [
                'name' => 'discount',
                'label' => 'Discount',
                'type' => 'number',
                'tab' => 'Item',
                'default' => "0.00",
                'decimals'      => 2,
                'attributes' => [
                    'id' => 'item-discount'
                ]
            ],
            [
                'name' => 'total_item',
                'type' => 'hidden',
                'tab' => 'Item',
                'default' => "0.00",
                'decimals'      => 2,
                'attributes' => [
                    'id' => 'item-total-item',
                    'readonly' => 'readonly',
                ]
            ],
            [
                'name' => 'total_amount',
                'label' => 'Total Amount',
                'type' => 'number',
                'tab' => 'Item',
                'default' => "0.00",
                'attributes' => [
                    'id' => 'item-total-amount',
                    'readonly' => 'readonly',
                ]
            ],
            [
                'name' => 'attachments',
                'type' => 'upload_multiple',
                'label' => 'Attachments',
                'upload'    => true,
                'tab' => 'Item'
            ],
            //Order
            [
                'name' => 'note',
                'label' => 'Customer Note',
                'type' => 'textarea',
                'tab' => 'Order',
            ],
            [
                'name' => 'assignee_id',
                'label' => 'Assignee',
                'type' => 'select2',
                'entity' => 'assignee',
                'attribute' => 'name',
                'default' => backpack_user()->id,
                'tab' => 'Order'
            ],
            [
                'name' => 'priority',
                'label' => 'Priority',
                'type' => 'select2_from_array',
                'options' => Order::PRIORITIES,
                'default' => 'medium',
                'tab' => 'Order'
            ],
            [
                'name' => 'ordered_at',
                'label' => 'Ordered At',
                'type' => 'datetime',
                'tab' => 'Order',
            ],
            [
                'name' => 'delivery',
                'label' => 'Delivery Type',
                'type' => 'select2_from_array',
                'options' => Order::DELIVERIES,
                'tab' => 'Delivery',
            ],
            [
                'name' => 'delivery_charge',
                'label' => 'Delivery Charge',
                'type' => 'number',
                'tab' => 'Delivery',
            ],
            [
                'name' => 'delivery_comment',
                'label' => 'Delivery Comment',
                'type' => 'textarea',
                'tab' => 'Delivery',
            ],
            //Delivery
            [
                'name' => 'delivered_at',
                'label' => 'Delivered At',
                'type' => 'datetime',
                'tab' => 'Delivery',
            ],
            //Other
            [
                'name' => 'orderNotes',
                'label' => 'Notes',
                'type' => 'relationship',
                'tab' => 'Other',
                'new_item_label' => 'Add ' . ucfirst(\Str::plural(setting('note_label', 'Note'))),
                'subfields' => [
                    [
                        'name' => 'note',
                        'type' => 'textarea',
                        'label' => 'Message',
                    ],
                    [
                        'name' => 'attachments',
                        'type' => 'upload_multiple',
                        'label' => 'Attachments',
                        'upload'    => true,
                    ],
                    [
                        'name' => 'author_id',
                        'type' => 'hidden',
                        'default' => backpack_user()->id,
                    ],
                ],
            ],
            [
                'name' => 'block_reason',
                'label' => 'Suspend/Block Reason',
                'type' => 'textarea',
                'tab' => 'Other',
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
