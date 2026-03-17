<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'kana' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|regex:/^[0-9\-]+$/|max:20',
            'company_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'postal_code' => 'nullable|digits:7',
            'address' => 'nullable|string|max:255',
            'address_detail' => 'nullable|string|max:255',
            'status' => 'required|in:' . implode(',', array_keys(Customer::STATUSES)),
            'rank' => 'required|in:' . implode(',', array_keys(Customer::RANKS)),
            'memo' => 'nullable|string|max:2000',
        ];
    }
}
