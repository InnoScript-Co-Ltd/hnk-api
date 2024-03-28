<?php

namespace App\Http\Requests;

use App\Models\Genres;
use App\Models\Song;
use Illuminate\Foundation\Http\FormRequest;

class GenreInSongUpdateRequest extends FormRequest
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
        $genreId = implode(',', Genres::all()->pluck('id')->toArray());

        return [
            'song_id' => "nullable|in:$songId",
            'genre_id' => "nullable|in:$genreId",
        ];
    }
}
