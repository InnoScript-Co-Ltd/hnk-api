<?php

namespace App\Http\Requests;

use App\Enums\REGXEnum;
use App\Helpers\Enum;
use App\Models\User;
use App\Enums\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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

        $mobileRule = REGXEnum::MOBILE_NUMBER->value;
        $adminStatusEnum = implode(',', (new Enum(UserStatusEnum::class))->values());
        $user = User::findOrFail(request('id'));
        $userId = $user->id;

        return [
            'name' => 'string | max: 24 | min: 4',
            'profile' => 'nullable | image:mimes:jpeg,png,jpg,gif|max:2048',
            'email' => "email | unique:users,email,$userId",
            'phone' => ["unique:users,phone,$userId", "regex:$mobileRule"],
            'status' => " nullable | in:$adminStatusEnum "
        ];
    }
}
