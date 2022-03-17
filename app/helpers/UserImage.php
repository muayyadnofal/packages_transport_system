<?php

namespace App\helpers;

use App\Models\Image;
use App\Models\Sender;
use App\Models\Traveler;
use App\Repositories\Eloquent\ImageRepository;
use Illuminate\Support\Facades\Storage;

class UserImage
{
    public function getImage($id, $type): ?array
    {
        if ($type == 'traveler') {
            $type = 'App\Models\Traveler';
        }

        else if ($type == 'sender') {
            $type = 'App\Models\Sender';
        }

        if (!$fImage = Image::where('imageable_id', $id)
            ->where('imageable_type', $type)->first())
        {
            return null;
        }

        return [
            'thumbnail' => $this->getImagePath($fImage, 'thumbnail'),
            'original' => $this->getImagePath($fImage, 'original'),
            'large' => $this->getImagePath($fImage, 'large')
        ];
    }

    private function getImagePath($image, $size): string
    {
        return Storage::disk($image->disk)
            ->url("uploads/images/{$size}/". $image->name);
    }
}
