<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait CanStoreFile
{
    public function store($disk, $path, $file): bool
    {
        if (Storage::disk($disk)->put($path, fopen($file, 'r+'))) {
            File::delete($file);
            return true;
        }
        return false;
    }
}
