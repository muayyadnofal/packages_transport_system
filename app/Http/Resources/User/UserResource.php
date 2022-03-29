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
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'role' => $this->role,
            'signed_at' => $this->created_at->diffForHumans(),
            'image' => $image->getImage($this->id, $this->role)
        ];
    }
}
