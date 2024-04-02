<?php

namespace App\Http\Requests;

use App\Models\Song;
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
        $songId = implode(',', Song::all()->pluck('id')->toArray());

        return [
            'name' => 'required|string|unique:singers,name',
            'profile' => 'required | image:mimes:jpeg,png,jpg,gif|max:2048',
            'song_id' => 'required',
            'song_id.*' => "required | in:$songId"
        ];
    }
}
