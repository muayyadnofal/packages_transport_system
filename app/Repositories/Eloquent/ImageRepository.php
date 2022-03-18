<?php

namespace App\Repositories\Eloquent;

use App\Models\Image;
use App\Repositories\Contracts\IImage;

class ImageRepository extends BaseRepository implements IImage
{
    public function model(): string
    {
        return Image::class;
    }

    public function checkUserImage($id, $type)
    {
        return $this->model::where('imageable_id', $id)
            ->where('imageable_type', $type)->first();
    }
}
