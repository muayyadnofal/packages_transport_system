<?php

namespace App\Repositories\Eloquent;

use App\Models\Request;
use App\Repositories\Contracts\IRequest;

class RequestRepository extends BaseRepository implements IRequest
{
    public function model(): string
    {
        return Request::class;
    }
}
