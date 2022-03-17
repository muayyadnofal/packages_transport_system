<?php

namespace App\Repositories\Eloquent;

use App\Models\Flight;
use App\Repositories\Contracts\IFlight;
use App\Repositories\Criteria\ICriteria;
use Illuminate\Support\Arr;

class FlightRepository extends BaseRepository implements IFlight
{
    public function model(): string
    {
        return Flight::class;
    }
}
