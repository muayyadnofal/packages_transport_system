<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SenderAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:senders,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required',
            'role' => 'required|string'
        ];
    }
}
