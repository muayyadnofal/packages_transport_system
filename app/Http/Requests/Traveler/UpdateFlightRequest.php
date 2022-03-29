<?php

namespace App\Http\Requests\Traveler;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlightRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
