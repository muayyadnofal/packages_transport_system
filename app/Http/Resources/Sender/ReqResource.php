<?php

namespace App\Http\Resources\Sender;

use App\helpers\RequestPackages;
use App\Http\Resources\Traveler\FlightResource;
use App\Http\Resources\User\UserResource;
use App\Models\Flight;
use App\Models\Request;
use App\Models\Traveler;
use Illuminate\Http\Resources\Json\JsonResource;

class ReqResource extends JsonResource
{
    public function toArray($request): array
    {
        $package = new RequestPackages();
        $packages = $package->getRequestPackages($this->id);
        $flight = Flight::where('id', $this->flight_id)->firstOrFail();
        $request = Request::find($this->id);

        return [
            'id' => $this->id,
            'status' => $this->status,
            'full_weight' => $this->full_weight,
            'sending_time' => $this->created_at->format('Y-m-d'),
            'acceptance_Time' => $request->Acceptance_Time,
            'fail_Time' => $request->Fail_Time,
            'packages' => PackageResource::collection($packages),
            'flight' => new FlightResource($flight),
        ];
    }
}
