<?php

namespace App\Http\Requests\Api\Front\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
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
            'name' => 'bail|required|string|min:2|max:50',
            'email' => [
                'bail',
                'required',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'phone' => [
                'bail',
                'required',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
                Rule::unique('users')->whereNull('deleted_at'), // egypt format
            ],
            'password' => 'required|min:8|max:150|confirmed',
            'address' => 'bail|required|string|min:2|max:50',
            'account_type' => 'bail|required|in:1,2',
        ];
    }
}
