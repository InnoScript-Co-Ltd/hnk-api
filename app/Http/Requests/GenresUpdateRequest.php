<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenresUpdateRequest extends FormRequest
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
            'name' => 'nullable | string',
            'rate' => 'nullable | numeric',
            'icon' => 'nullable | image:mimes:jpeg,png,jpg,gif|max:2048',
            'color' => 'nullable | string',
            'auto_rate' => 'nullable | string | in:ACTIVE,DISABLE',
            'status' => 'nullable | string | in:ACTIVE,DISABLE',
        ];
    }
}
