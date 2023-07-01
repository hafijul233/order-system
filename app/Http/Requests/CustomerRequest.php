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
        $rules['platform'] = ['required', Rule::in(array_keys(config('constant.platforms')))];
        $rules['status_id'] = ['required', Rule::in(Customer::statusesId())];
        $rules['email_verified_at'] = ['nullable', 'date', 'before:' . now()];
        $rules['phone_verified_at'] = ['nullable', 'date', 'before:' . now()];
        $rules['block_reason'] = ['nullable', 'min:3', 'max:255', 'string'];
        $rules['note'] = ['nullable', 'min:3', 'max:255', 'string'];
        $rules['newsletter_subscribed'] = ['nullable', 'boolean'];
        $rules['password'] = ['nullable', 'required_if:allowed_login,==,1', 'confirmed', Password::default()];

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

    public function messages() {
        
        return [
           'password.required_if' => 'The password field is required if customer allowed to logged.' 
        ];
    }
}
