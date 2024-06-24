<?php

namespace App\Http\Requests;

use App\Models\Singer;
use Illuminate\Foundation\Http\FormRequest;

class SingerUpdateRequest extends FormRequest
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
        $singer = Singer::findOrFail(request('id'));
        $singerId = $singer->id;

        return [
            'name' => "nullable | string | unique:singers,name,$singerId",
            'profile' => 'nullable | image:mimes:jpeg,png,jpg|max:2048',
            'show_slider' => "nullable | in:ACTIVE,DISABLE",
            'slider_description' => 'nullable | string',
            'slider_image' => 'nullable | image:mimes:jpeg,png,jpg|max:2048',
            'cover_photo' => 'nullable | image:mimes:jpeg,png,jpg|max:2048',
            'detail_title' => 'nullable |string',
            'invite_video' => "nullable | file",
            'status' => 'nullable | string | in:ACTIVE,DISABLE',
        ];
    }
}
