<?php

namespace Aliqsm\LaravelAuthkit\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'string',
                'max:255',
                'confirmed',
                // Password::min(8)->letters()->mixedCase()->numbers(),
            ],
        ];
    }
}