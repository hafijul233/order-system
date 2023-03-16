<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
            'name' => ['string', 'required', 'min:1', 'max:255'],
            'representative' => ['string', 'required', 'min:1', 'max:255'],
            'designation' => ['string', 'nullable', 'min:1', 'max:255'],
            'email' => ['string', 'nullable', 'min:1', 'max:255', 'nullable'],
            'phone' => ['string', 'required', 'min:1', 'max:255'],
            'status' => ['string', 'required', 'min:1', 'max:255', Rule::in(array_keys(Company::STATUSES))],
            'block_reason' => ['string', 'nullable', 'min:1', 'max:255', 'nullable'],
            'note' => ['string', 'nullable', 'min:1', 'max:255', 'nullable'],
        ];
    }
}
