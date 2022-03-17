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
}
