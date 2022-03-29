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
            'launch_day' => 'required',
            'landing_day' => 'required|after:launch_day',
            'launch_time' => "required",
            'landing_time' => "required",
            'full_load_amount' => 'required|integer',
            'free_load_amount' => 'required|integer',
        ];
    }
}
