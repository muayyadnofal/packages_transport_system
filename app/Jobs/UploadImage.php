<?php

namespace App\Jobs;

use App\Traits\CanResizeImage;
use App\Traits\CanStoreFile;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\Log;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use CanResizeImage, CanStoreFile;

    protected $image;

    public function __construct(ImageModel $image)
    {
        $this->image = $image;
    }

    public function handle()
    {
        $disk = $this->image->disk;
        $fileName = $this->image->name;

        $original_file = storage_path() . '/uploads/original/' . $fileName;
        $thumbnail_file = storage_path('/uploads/thumbnail/' . $fileName);
        $large_file = storage_path('/uploads/large/' . $fileName);

        $largeImagesPath = 'uploads/images/large/' . $fileName;
        $thumbnailImagesPath = 'uploads/images/thumbnail/' . $fileName;
        $originalImagesPath = 'uploads/images/original/' . $fileName;
//
        try {
            $largeImage = self::resize($original_file, $large_file, 800, 600);
            self::store($disk, $largeImagesPath, $largeImage);

            $thumbnailImage = self::resize($original_file, $thumbnail_file, 250, 200);
            self::store($disk, $thumbnailImagesPath, $thumbnailImage );

            self::store($disk, $originalImagesPath, $original_file);

            // update the database record with success flag
            $this->image->update(['upload_successful' => true]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
