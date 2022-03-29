<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sender\SenderResource;
use App\Repositories\Contracts\ISender;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class SenderController extends Controller
{
    use HttpResponse;

    private $sender;

    public function __construct(ISender $sender)
    {
        $this->sender = $sender;
    }

    public function index(): \Illuminate\Http\Response
    {
        $senders = $this->sender->withCriteria([
            new LatestFirst()
        ])->all();

        return self::returnData('senders', SenderResource::collection($senders), 'all senders', 200);
    }
}
