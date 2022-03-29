<?php

namespace App\Http\Resources\Admin;

use App\helpers\RequestPackages;
use App\Http\Resources\Sender\PackageResource;
use App\Http\Resources\Traveler\FlightResource;
use App\Models\Flight;
use App\Models\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        $package = new RequestPackages();
        $packages = $package->getRequestPackages($this->id);

        return [
            'id' => $this->id,
            'status' => $this->status,
            'full_weight' => $this->full_weight,
            'sending_time' => $this->created_at->diffForHumans(),
            'acceptance_Time' => $request->Acceptance_Time,
            'fail_Time' => $request->Fail_Time,
            'packages' => PackageResource::collection($packages),
        ];
    }
}
