<?php

namespace App\Repositories\Eloquent;

use App\Models\Traveler;
use App\Repositories\Contracts\ITraveler;

class TravelerRepository extends BaseRepository implements ITraveler
{
    public function model(): string
    {
        return Traveler::class;
    }

    public function getNotifications($id)
    {
        $traveler = $this->find($id);
        return $traveler->userNotifications;
    }

    public function sendNotification($id, $data)
    {
        $traveler = $this->find($id);
        return $traveler->userNotifications()->create($data);
    }
}
