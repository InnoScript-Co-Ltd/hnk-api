<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SingerStoreRequest extends FormRequest
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
            'name' => 'required|string|unique:singers,name',
            'slider_description' => 'required | string',
            'slider_image' => 'required | image:mimes:jpeg,png,jpg|max:2048',
            'cover_photo' => 'required | image:mimes:jpeg,png,jpg|max:2048',
            'detail_title' => 'required |string',
            'profile' => 'required | image:mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
