<?php

namespace App\Http\Requests;

use App\Models\Singer;
use App\Models\Song;
use Illuminate\Foundation\Http\FormRequest;

class SingerSongStoreRequest extends FormRequest
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
        $singerId = implode(',', Singer::all()->pluck('id')->toArray());

        return [
            'song_id' => "required|in:$songId",
            'singer_id' => "required|in:$singerId",
            'color' => 'nullable|string',
            'sologram' => 'nullable|string'
        ];
    }
}
