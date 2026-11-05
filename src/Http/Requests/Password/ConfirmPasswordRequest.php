<?php

namespace Aliqsm\LaravelAuthkit\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'password' => 'required|string|current_password',
        ];
    }
}
