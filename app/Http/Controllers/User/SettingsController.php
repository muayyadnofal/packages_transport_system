<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Upload\ImageRequest;
use App\Http\Requests\User\SettingsRequest;
use App\Http\Resources\User\UserResource;
use App\Traits\CanUploadImage;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use HttpResponse, CanUploadImage;

    public function updateProfile(SettingsRequest $settingRequest, ImageRequest $imageRequest)
    {
        $user = auth()->user();
        $user->update($settingRequest->all());
        return self::upload($imageRequest);
        return self::returnData('user', new UserResource($user), 'user profile updated', 200);
    }
}
