<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class TravelerAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:travelers,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required',
            'role' => 'required|string'
        ];
    }
}
