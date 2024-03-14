<?php

namespace App\Http\Requests;

use App\Models\Singer;
use App\Models\Genres;
use Illuminate\Foundation\Http\FormRequest;

class GenreInSingerUpdateRequest extends FormRequest
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
        $singerId = implode(',', Singer::all()->pluck('id')->toArray());
        $genreId = implode(',', Genres::all()->pluck('id')->toArray());

        return [
            'singers_id' => "nullable|in:$singerId",
            'genre_id' => "nullable|in:$genreId"
        ];
    }
}
