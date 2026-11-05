<?php

namespace Aliqsm\LaravelAuthkit\Http\Requests\TwoFactor;

use Illuminate\Foundation\Http\FormRequest;

class TwoFactorChallengeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


      protected function prepareForValidation(): void
    {
        $code = $this->input('code');

        if (is_string($code)) {
            $this->merge(['code' => trim($code)]);
        }
    }


    public function rules(): array
    {
        return [
            'code' => 'required|string|max:64',
        ];
    }
}
