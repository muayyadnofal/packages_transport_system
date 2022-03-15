<?php

namespace App\helpers;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class UserImage
{
    public function getImage($id): array
    {
        $image = Image::where('imageable_id', $id)->first();
        return [
            'thumbnail' => $this->getImagePath($image, 'thumbnail'),
            'original' => $this->getImagePath($image, 'original'),
            'large' => $this->getImagePath($image, 'large')
        ];
    }

    private function getImagePath($image, $size): string
    {
        return Storage::disk($image->disk)
            ->url("uploads/images/{$size}/". $image->name);
    }
}
