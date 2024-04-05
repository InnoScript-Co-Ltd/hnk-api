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
            'status' => 'nullable | string | in:ACTIVE,DISABLE',
        ];
    }
}
