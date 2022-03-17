<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IImage;

class ImageRepository extends BaseRepository implements IImage
{
    public function checkUserImage($id, $type)
    {
        return $this->model::where('imageable_id', $id)
            ->where('imageable_type', $type)->first();
    }
}
