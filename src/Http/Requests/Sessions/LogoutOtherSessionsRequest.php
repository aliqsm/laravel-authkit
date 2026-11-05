<?php

namespace Aliqsm\LaravelAuthkit\Http\Requests\Sessions;

use Illuminate\Foundation\Http\FormRequest;

class LogoutOtherSessionsRequest extends FormRequest
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