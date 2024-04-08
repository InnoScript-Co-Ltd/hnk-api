<?php

namespace App\Http\Requests;

use App\Enums\REGXEnum;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => 'required | string | max: 24 | min: 8',
            'email' => 'required | email',
            'phone' => ['required', 'unique:users,phone'],
            'dob' => 'required|string',
            'fav_music' => 'required|array',
        ];
    }
}
