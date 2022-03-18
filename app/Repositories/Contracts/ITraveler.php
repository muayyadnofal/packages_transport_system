<?php

namespace App\Repositories\Contracts;

interface ITraveler
{
    public function getNotifications($id);
    public function sendNotification($id, $data);
}
