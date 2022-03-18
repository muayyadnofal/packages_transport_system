<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Contracts\INotification;

class NotificationRepository extends BaseRepository implements INotification
{
    public function model(): string
    {
        return Notification::class;
    }
}
