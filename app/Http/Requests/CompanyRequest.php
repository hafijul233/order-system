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
            'representative' => ['required', 'min:1', 'max:255'],
            'designation' => ['string', 'nullable', 'min:1', 'max:255'],
            'email' => ['min:5', 'max:255', 'email:rfs,dns', 'nullable', 'required_if:newsletter_subscribed,==,true',
                Rule::unique('companies', 'email')->ignore(request()->route('id'))],
            'phone' => ['string', 'required', 'min:1', 'max:255'],
            'status_id' => ['required', Rule::in(Company::statusesId())],
            'block_reason' => ['string', 'nullable', 'min:1', 'max:255', 'nullable'],
            'note' => ['string', 'nullable', 'min:1', 'max:255', 'nullable'],
        ];
    }
}
