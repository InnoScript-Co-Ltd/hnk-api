<?php

namespace App\Http\Requests;

use App\Models\Song;
use App\Models\Genres;
use Illuminate\Foundation\Http\FormRequest;

class GenreInSongStoreRequest extends FormRequest
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
            'song_id' => "required|in:$songId",
            'genre_id' => "required|in:$genreId"
        ];
    }
}
