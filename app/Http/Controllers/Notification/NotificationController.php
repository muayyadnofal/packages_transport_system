<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use HttpResponse;

    private $traveler, $sender;

    public function __construct(ITraveler $traveler, ISender $sender)
    {
        $this->traveler = $traveler;
        $this->sender = $sender;
    }

    public function getNotifications()
    {
        $notifications = [];
        $user = auth()->user();
        $id = $user->id;

        if ($user->type == 'sender') {
            $notifications = $this->sender->getNotifications($id);
        }

        if ($user->type == 'traveler') {
            $notifications = $this->traveler->getNotifications($id);
        }

        return self::returnData('notifications', NotificationResource::collection($notifications), 'all notifications', 200);
    }
}
