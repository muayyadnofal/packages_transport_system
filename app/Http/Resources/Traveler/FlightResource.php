<?php

namespace App\Http\Resources\Traveler;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'traveler_id' => $this->traveler_id,
            'traveler' => new UserResource($this->traveler),
            'launch_city' => $this->launch_city,
            'landing_city' => $this->landing_city,
            'launch_time' => $this->launch_time,
            'landing_time' => $this->landing_time,
            'full_load_amount' => $this->full_load_amount,
            'free_load_amount' => $this->free_load_amount,
        ];
    }
}
