<?php

namespace App\Http\Requests;
use AllowDynamicProperties;
use Illuminate\Foundation\Http\FormRequest;

#[AllowDynamicProperties] class CustomerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone_number' => 'required|string|max:13',
            'name' => 'required|string|max:20',
            'inn' => 'nullable|string|max:12',
            'addresses' => 'nullable|array',
            'addresses.*.id' => 'nullable|integer',
            'addresses.*.name' => 'nullable|string|max:1000',
            'addresses.*.apartment' => 'nullable|string|max:1000',
            'addresses.*.street' => 'nullable|string|max:1000',
            'addresses.*.house' => 'nullable|string|max:1000',
            'addresses.*.description' => 'nullable|string|max:1000',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'ip' => \Request::ip(),
        ]);
    }
}