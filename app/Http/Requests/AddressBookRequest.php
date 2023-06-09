<?php

namespace App\Http\Requests;

use App\Models\AddressBook;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressBookRequest extends FormRequest
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
        return [
            'addressable' => ['required', 'min:1', 'string'],
            'type' => ['required', 'string', Rule::in(array_keys(AddressBook::TYPES))],
            'street_address' => ['nullable', 'min:3', 'max:255', 'string'],
            'city' => ['required', 'min:2', 'max:255', 'string'],
            'state' => ['required', 'min:2', 'max:255', 'string'],
            'zip_code' => ['nullable', 'min:1', 'max:100000', 'integer'],
            'phone' => ['required', 'min:10', 'string'],
            'landmark' => ['nullable', 'min:3', 'max:255', 'string'],
            'status' => ['required', 'string', Rule::in(array_keys(AddressBook::STATUSES))],
            'block_reason' => ['nullable', 'min:3', 'max:255', 'string'],
            'note' => ['nullable', 'min:3', 'max:255', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->request->has('addressable')) {
            [$addressable_type, $addressable_id] = explode(':', $this->addressable);
            $this->mergeIfMissing(['addressable_id' => $addressable_id, 'addressable_type' => $addressable_type]);
        }
    }

}
