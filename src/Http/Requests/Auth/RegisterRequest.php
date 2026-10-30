<?php

namespace Aliqsm\LaravelAuthkit\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->name) ? trim($this->name) : $this->name,
            'email' => is_string($this->email) ? strtolower(trim($this->email)) : $this->email,
        ]);
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email:rfc|max:255|unique:users,email',
            'password' => [
                'required',
                'max:255',
                'confirmed',
                // Password::min(8)->letters()->mixedCase()->numbers(), // => شروع بشه min حتما باید از
                // ->mixedCase()->symbols()
            ],
        ];
    }
}
