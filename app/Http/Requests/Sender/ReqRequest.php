<?php

namespace App\Http\Requests\Sender;

use Illuminate\Foundation\Http\FormRequest;

class ReqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_weight' => 'required|integer',
        ];
    }
}
