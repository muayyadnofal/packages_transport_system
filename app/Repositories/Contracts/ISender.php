<?php

namespace App\Repositories\Contracts;

interface ISender
{
    public function getNotifications($id);
    public function sendNotification($id, $data);
}
