<?php

namespace App\Repositories\Eloquent;

use App\Models\Sender;
use App\Repositories\Contracts\ISender;

class SenderRepository extends BaseRepository implements ISender
{
    public function model(): string
    {
        return Sender::class;
    }

    public function getNotifications($id)
    {
        $sender = $this->find($id);
        return $sender->userNotifications;
    }

    public function sendNotification($id, $data)
    {
        $sender = $this->find($id);
        return $sender->userNotifications()->create($data);
    }
}
