<?php

namespace Aliqsm\LaravelAuthkit\Http\Requests\TwoFactor;

use Illuminate\Foundation\Http\FormRequest;

class EnableTwoFactorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'code' => 'required|string|digits:6',
        ];
    }
}
