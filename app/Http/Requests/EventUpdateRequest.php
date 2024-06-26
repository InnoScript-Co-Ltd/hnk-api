<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'name' => 'nullable|string',
            'cover_photo' => 'nullable|file',
            'status' => 'nullable | string | in:ACTIVE,DISABLE',
            'location' => 'nullable | string',
            'address' => 'nullable | string',
            'phone' => 'nullable | string',
            'date' => 'nullable | string',
            'time' => 'nullable | string',
            'promotion' => 'nullable | string',
            'artist_lineup' => 'nullable | string',
        ];
    }
}
