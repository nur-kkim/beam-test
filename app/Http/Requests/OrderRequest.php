<?php

namespace App\Http\Requests;
use AllowDynamicProperties;
use Illuminate\Foundation\Http\FormRequest;

#[AllowDynamicProperties] class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'device_id' => 'required|int|exists:devices,id',
            'address_id' => 'required|int|exists:addresses,id',
            'delivery_time' => 'nullable|date'
        ];
    }
}