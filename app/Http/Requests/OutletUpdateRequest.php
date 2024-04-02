<?php

namespace App\Http\Requests;

use App\Enums\REGXEnum;
use App\Models\Outlet;
use Illuminate\Foundation\Http\FormRequest;

class OutletUpdateRequest extends FormRequest
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
        $mobileRule = REGXEnum::LOCAL_NUMBER->value;
        $outlet = Outlet::findOrFail(request('id'));
        $outletId = $outlet->id;

        return [
            'name' => 'nullable|string|max:255',
            'phone' => ['nullable', "unique:outlets,phone,$outletId", "regex:$mobileRule"],
            'address' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable|string|time',
            'promotion' => 'nullable|string|max:255',
            'promo_description' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'nullable | string | in:ACTIVE,DISABLE',
            'image' => 'nullable | image:mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
