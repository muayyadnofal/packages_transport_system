<?php

namespace App\Http\Requests\Sender;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'weight' => 'required|integer'
        ];
    }
}
