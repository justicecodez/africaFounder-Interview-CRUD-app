<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email:rfc,dns', // checks format + domain existence
                'max:100',
                'exists:users,email', // email must exist in users table
            ],
            'password' => [
                'required',
                'string',
                'min:8',  // basic length requirement
                'max:64', // prevent extremely long passwords
            ],
        ];
    }

    /**
     * Get custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a valid string.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email must not exceed 100 characters.',
            'email.exists' => 'No account found with this email address.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.max' => 'Password must not exceed 64 characters.',
        ];
    }
}
