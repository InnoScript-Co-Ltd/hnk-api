<?php

namespace App\Http\Requests;

use App\Models\Singer;
use App\Models\Song;
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
        $songId = implode(',', Song::all()->pluck('id')->toArray());
        $singer = Singer::findOrFail(request('id'));
        $singerId = $singer->id;

        return [
            'name' => "nullable | string | unique:singers,name,$singerId",
            'profile' => 'nullable | image:mimes:jpeg,png,jpg,gif|max:2048',
            'song_id' => 'nullable',
            'song_id.*' => "nullable | in:$songId",
            'status' => 'nullable | string | in:ACTIVE,DISABLE',
        ];
    }
}
