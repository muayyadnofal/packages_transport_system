<?php

namespace App\Traits;

use App\Jobs\UploadImage;

trait CanUploadImage
{
    private $request;

    public function upload($request): bool
    {
        // get the image
        $image = $request->file('image');

        // get the original path name and replace any spaces with _
        $file_name = time()."_". preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        // move the img to the temporary location (tmp)
        $tmp = $image->storeAs('uploads/original/', $file_name, 'tmp');

        // create the database record for the user
        $userImage = auth()->user()->image()->create([
            'name' => $file_name,
            'disk' => config('site.upload_disk')
        ]);

        // dispatch a job to handle the image manipulation
        if ($this->dispatch(new UploadImage($userImage))) {
            return true;
        }

        return false;
    }
}
