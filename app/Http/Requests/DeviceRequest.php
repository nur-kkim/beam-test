<?php

namespace App\Http\Requests;
use AllowDynamicProperties;
use Illuminate\Foundation\Http\FormRequest;

#[AllowDynamicProperties] class DeviceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:256',
            'slug' => 'required|string|max:256',
            'description' => 'nullable|string|max:1000',
        ];
    }
}