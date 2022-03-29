<?php

namespace App\Http\Resources\Traveler;

use App\helpers\UserImage;
use App\Repositories\Eloquent\FlightRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelerResource extends JsonResource
{
    public function toArray($request)
    {
        $image = new UserImage();
        $flight = new FlightRepository();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'role' => $this->role,
            'signed_at' => $this->created_at->diffForHumans(),
            'image' => $image->getImage($this->id, $this->role),
            'flights' => FlightResource::collection($flight->findWhere('traveler_id', $this->id))
        ];
    }
}
