<?php

namespace App\Http\Requests;

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
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'promotion' => 'required|string|max:255',
            'promo_description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }
}
