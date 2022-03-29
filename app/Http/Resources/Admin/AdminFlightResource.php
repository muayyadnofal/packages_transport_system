<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Sender\ReqResource;
use App\Http\Resources\User\UserResource;
use App\Models\Traveler;
use App\Repositories\Eloquent\RequestRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminFlightResource extends JsonResource
{
    public function toArray($request)
    {
        $traveler = Traveler::where('id', $this->traveler_id)->firstOrFail();

        $req = new RequestRepository();

        return [
            'id' => $this->id,
            'traveler_id' => $this->traveler_id,
            'launch_city' => $this->launch_city,
            'landing_city' => $this->landing_city,
            'launch_day' => $this->launch_day,
            'landing_day' => $this->landing_day,
            'launch_time' => $this->launch_time,
            'landing_time' => $this->landing_time,
            'full_load_amount' => $this->full_load_amount,
            'free_load_amount' => $this->free_load_amount,
            'created_at' => $this->created_at->diffForHumans(),
            'traveler' => new UserResource($traveler),
            'requests' => AdminRequestResource::collection($req->findWhere('flight_id', $this->id))
        ];
    }
}
