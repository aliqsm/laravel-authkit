<?php

namespace Aliqsm\LaravelAuthkit\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation(): void
    {
        $email = $this->input('email');

        $this->merge([
            'email' => is_string($email) ? strtolower(trim($email)) : $email,
        ]);
    }


    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'token' => 'required|string',
            'password' => [
                'required',
                'string',
                'max:255',
                'confirmed',
                // Password::min(8)->letters()->mixedCase()->numbers(), // => شروع بشه min حتما باید از
            ],
        ];
    }
}
