<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('payment', 'payments');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id')->label('#');
        CRUD::column('order_id')->type('relationship')->label('Order');
        CRUD::column('message')->type('text');
        CRUD::column('payment_option')->type('relationship')->label('Option');
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'custom_html',
            'value' => fn(Payment $order) => $order->status_html
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
        CRUD::setValidation(PaymentRequest::class);

        CRUD::addField([
            'name' => 'order_id',
            'label' => 'Order',
            'type' => 'select2',
            'entity'        => 'order',
            'attribute'     => 'reference_no',
            'query' => function($query) {
                return $query->where('type', '=', 'order');
            } 
        ]);
        CRUD::field('message')->type('text');
        CRUD::field('paymentOption')->type('select2')->label('Method');
        CRUD::field('amount')->type('number')->attributes(['id' => 'payment-amount']);
        CRUD::field('due')->type('number')->attributes(['id' => 'payment-due', 'readonly' => 'readonly']);
        CRUD::field('installment_type')->type('select_from_array')
        ->options(['full' => 'Complete', 'partial' => 'Partial', 'pending' => 'Pending']);
        CRUD::addField([
            'name' => 'status_id',
            'label' => 'Status',
            'type' => 'select2_from_array',
            'options' => Payment::statusDropdown(),
            'default' => Payment::defaultStatusId(),
        ]);
        CRUD::field('notes')->type('textarea')->label('Notes');
        CRUD::addField(            [
            'name' => 'attachments',
            'type' => 'upload_multiple',
            'label' => 'Attachments',
            'upload'    => true,
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
