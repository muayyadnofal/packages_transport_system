<?php

namespace App\Http\Resources\Sender;

use App\helpers\UserImage;
use App\Http\Resources\Traveler\FlightResource;
use App\Repositories\Eloquent\FlightRepository;
use App\Repositories\Eloquent\RequestRepository;
use App\Repositories\Eloquent\SenderRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class SenderResource extends JsonResource
{
    public function toArray($request)
    {
        $image = new UserImage();
        $req = new RequestRepository();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'role' => $this->role,
            'signed_at' => $this->created_at->diffForHumans(),
            'image' => $image->getImage($this->id, $this->role),
            'requests' => ReqResource::collection($req->findWhere('sender_id', $this->id))
        ];
    }
}
