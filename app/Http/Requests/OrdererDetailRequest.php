<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrdererDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in([Customer::class, Company::class])],
            'id' => ['required', 'integer', 'min:1'],
        ];
    }
}
