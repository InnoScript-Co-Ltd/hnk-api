<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class MusicStoreRequest extends FormRequest
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
        $userId = implode(',', User::all()->pluck('id')->toArray());

        return [
            'user_id' => "required|in:$userId",
            'audios' => 'required|array|min:1',
            'audios.*' => 'required|file|mimes:mp3|max:20000',
        ];
    }
}
