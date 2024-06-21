<?php

namespace App\Http\Requests;

use App\Models\Singer;
use Illuminate\Foundation\Http\FormRequest;

class EpisodeStoreRequest extends FormRequest
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

        return [
            'singer_id' => "required | in:$singerId",
            'title' => 'required | string',
            'url' => 'required | string',
            'status' => 'required | in:ENABLE,DISABLE',
        ];
    }
}
