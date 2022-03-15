<?php

namespace App\Repositories\Eloquent;

use App\Models\Flight;
use App\Repositories\Contracts\IFlight;

class FlightRepository extends BaseRepository implements IFlight
{
    public function model(): string
    {
        return Flight::class;
    }
}
