<?php

namespace Aliqsm\LaravelAuthkit\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
        ];
    }
}
