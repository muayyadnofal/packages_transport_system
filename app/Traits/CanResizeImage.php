<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;

trait CanResizeImage
{
    public function resize($image, $uploadPath, $width, $height)
    {
        Image::make($image)
            ->fit($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($resizedImage = $uploadPath);

        return $resizedImage;
    }
}
