<?php

namespace App\Http\Requests\Auth;

use App\Rules\user\UserType;
use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expires' => 'required',
            'signature' => 'required',
            'type' => [new UserType]
        ];
    }
}
