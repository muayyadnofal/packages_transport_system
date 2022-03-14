<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Upload\ImageRequest;
use App\Traits\CanUploadImage;
use App\Traits\HttpResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

class UserImageController extends Controller
{
    use HttpResponse, CanUploadImage;

    public function create(Request $request)
    {
        if (self::upload($request)) {
            return self::success('image uploaded successfully', 201);
        }
        return self::failure('can\'t upload image', 422);
    }
}
