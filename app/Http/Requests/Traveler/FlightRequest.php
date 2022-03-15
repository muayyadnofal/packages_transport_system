<?php

namespace App\Http\Requests\Traveler;

use Illuminate\Foundation\Http\FormRequest;

class FlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'traveler_id' => 'required|integer',
            'launch_city' => 'required|string',
            'landing_city' => 'required|string',
            'launch_time' => 'required|date',
            'landing_time' => 'required|date',
            'full_load_amount' => 'required|integer',
            'free_load_amount' => 'required|integer',
        ];
    }
}
