<?php

namespace App\Http\Requests;

use App\Models\Genres;
use Illuminate\Foundation\Http\FormRequest;

class VoteGenreRequest extends FormRequest
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
        $genres = implode(',', Genres::pluck('name')->toArray());

        return [
            'vote_genre' => "required | string | in:$genres",
        ];
    }
}
