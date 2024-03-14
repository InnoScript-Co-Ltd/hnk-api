<?php

namespace App\Http\Requests;

use App\Models\GenreInSong;
use Illuminate\Foundation\Http\FormRequest;

class LyricUpdateRequest extends FormRequest
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
        $songId = implode(',', GenreInSong::all()->pluck('id')->toArray());

        return [
            'song_id' => "required|in:$songId",
            'lyrics' => 'required|string',
        ];
    }
}
