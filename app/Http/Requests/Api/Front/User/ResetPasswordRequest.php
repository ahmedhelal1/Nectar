<?php

namespace App\Http\Requests\Api\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
        return [
            'email' => 'bail|required|email|exists:users,email',
            'new_password' => 'bail|required|min:8|max:150|confirmed|different:current_password',
            'new_password_confirmation' => 'sometimes|same:new_password',
            'code' => 'required|digits:4'
        ];
    }
}
