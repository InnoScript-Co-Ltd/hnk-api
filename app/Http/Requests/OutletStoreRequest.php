<?php

namespace App\Http\Requests;

use App\Enums\REGXEnum;
use Illuminate\Foundation\Http\FormRequest;

class OutletStoreRequest extends FormRequest
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
        $mobileRule = REGXEnum::LOCAL_NUMBER->value;

        return [
            'name' => 'required|string|max:255',
            'phone' => ['unique:outlets,phone', "regex:$mobileRule"],
            'address' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'promotion' => 'required|string|max:255',
            'promo_description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'required | image:mimes:jpeg,png,jpg|max:2048',
            'branch' => 'nullable | string',
            'month' => 'nullable | string',
            'activation_date' => 'nullable | string',
            'description' => 'nullable|string',
            'music_band' => 'nullable|string',
        ];
    }
}
