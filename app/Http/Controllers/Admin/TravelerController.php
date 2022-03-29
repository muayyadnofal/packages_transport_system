<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Traveler\TravelerResource;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\Repositories\Eloquent\Criteria\LatestFirst;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class TravelerController extends Controller
{
    use HttpResponse;

    private $traveler;

    public function __construct(ITraveler $traveler)
    {
        $this->traveler = $traveler;
    }

    public function index(): \Illuminate\Http\Response
    {
        $travelers = $this->traveler->withCriteria([
            new LatestFirst()
        ])->all();

        return self::returnData('travelers', TravelerResource::collection($travelers), 'all travelers', 200);
    }
}
