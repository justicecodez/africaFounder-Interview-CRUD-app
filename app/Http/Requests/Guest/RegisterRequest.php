<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s\-\'\.]+$/', // allows letters, spaces, hyphens, apostrophes, dots
                'min:3',
                'max:50',
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns', // RFC-compliant + checks domain via DNS
                'max:100',
                'unique:users,email', // prevent duplicate accounts
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:64',
                'regex:/[A-Z]/', // must contain uppercase
                'regex:/[a-z]/', // must contain lowercase
                'regex:/[0-9]/', // must contain number
                'regex:/[@$!%*#?&]/', // must contain special char
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than 50 characters.',
            'name.regex' => 'The name may only contain letters, spaces, hyphens, apostrophes, and dots.',
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'email.max' => 'The email may not be greater than 100 characters.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password may not be greater than 64 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
