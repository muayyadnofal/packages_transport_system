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

    public function applyFilters()
    {
        return $this->model->allFlights();
    }

    public function createRequest($id)
    {
        $flight = $this->find($id);
        $sender = auth()->user()->id;
        $data = ['sender_id' => $sender];
        return $flight->requests()->create($data);
    }

    public function modifyFlightFreeAmount($request)
    {
        $flight = $this->findWhereFirst('id', $request->flight_id);
        $this->forceFill(['free_load_amount' => ($flight->free_load_amount + $request->full_weight)], $flight->id);
    }
}
