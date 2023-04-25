<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules['name'] = ['required', 'min:3', 'max:255', 'string'];
        $rules['email'] = [
            'min:5', 'max:255', 'email:rfs,dns', 'nullable', 'required_if:newsletter_subscribed,==,true',
            Rule::unique('customers', 'email')->ignore(request()->route('id')),
        ];
        $rules['phone'] = ['required', 'min:10', 'max:255', 'string', 'nullable'];
        $rules['type'] = ['required', Rule::in(array_keys(Customer::TYPES))];
        $rules['status'] = ['required', Rule::in(Customer::statusesId())];
        $rules['email_verified_at'] = ['nullable', 'date', 'before:' . now()];
        $rules['phone_verified_at'] = ['nullable', 'date', 'before:' . now()];
        $rules['block_reason'] = ['nullable', 'min:3', 'max:255', 'string'];
        $rules['note'] = ['nullable', 'min:3', 'max:255', 'string'];
        $rules['newsletter_subscribed'] = ['nullable', 'boolean'];
        $rules['password'] = ($this->method() == 'POST')
            ? ['required', 'min:5', 'max:255', 'confirmed', Password::default()]
            : ['nullable', 'min:5', 'max:255', 'confirmed'];

        return $rules;
    }

    protected function prepareForValidation()
    {
        if ($this->method() == 'PUT') {
            if ($this->input('password') == null) {
                $this->offsetUnset('password');
            }
        }
    }
}
