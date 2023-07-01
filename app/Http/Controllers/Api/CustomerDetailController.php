<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerDetailResource;
use App\Models\Customer;

class CustomerDetailController extends Controller
{
    public function __invoke(Customer $customer): CustomerDetailResource
    {
        $customer->load('addresses');

        return new CustomerDetailResource($customer);
    }
}
