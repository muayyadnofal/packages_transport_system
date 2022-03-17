<?php

namespace App\Http\Resources\User;

use App\helpers\UserImage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $image = new UserImage();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'image' => $image->getImage($this->id, $this->type)
        ];
    }
}
