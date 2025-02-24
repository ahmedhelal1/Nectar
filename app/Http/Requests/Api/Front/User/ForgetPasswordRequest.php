<?php

namespace App\Http\Requests\Api\Front\User;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
            'current_password' => 'bail|required|current_password|min:8|max:150',
            'new_password' => 'bail|required|min:8|max:150|confirmed|different:current_password',

        ];
    }
}
