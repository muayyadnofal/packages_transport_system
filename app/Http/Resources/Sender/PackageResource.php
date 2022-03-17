<?php

namespace App\Http\Resources\Sender;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'weight' => $this->weight,
        ];
    }
}
