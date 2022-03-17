<?php

namespace App\Http\Requests\Traveler;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class FlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $current_date = Carbon::now()->format('Y-m-d');
        return [
            'launch_city' => 'required|string',
            'landing_city' => 'required|string',
            'launch_day' => 'required|date_format:d/m/Y',
            'landing_day' => 'required|date_format:d/m/Y|after:launch_day',
            'launch_time' => "required|date_format:H:i",
            'landing_time' => "required|date_format:H:i",
            'full_load_amount' => 'required|integer',
            'free_load_amount' => 'required|integer',
        ];
    }
}
