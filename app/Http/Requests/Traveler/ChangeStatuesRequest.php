<?php

namespace App\Http\Requests\Traveler;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatuesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string'
        ];
    }
}
