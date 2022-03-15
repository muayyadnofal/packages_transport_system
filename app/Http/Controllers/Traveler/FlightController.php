<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Http\Requests\Traveler\FlightRequest;
use App\Http\Resources\Traveler\FlightResource;
use App\Repositories\Contracts\IFlight;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    use HttpResponse;

    protected $flight;

    public function __construct(IFlight $flight)
    {
        $this->flight = $flight;
    }

    public function index(): \Illuminate\Http\Response
    {
        $flights = $this->flight->all();
        return self::returnData('flights', FlightResource::collection($flights), 'all flights', 200);
    }

    public function create(FlightRequest $request): \Illuminate\Http\Response
    {
        $flight = $this->flight->create($request->all());
        return self::returnData('flight', new FlightResource($flight), 'flight created', 201);
    }

    public function update(FlightRequest $request, $id): \Illuminate\Http\Response
    {
        $this->authorize('update', $id);
        $flight = $this->flight->update($id, $request->except('traveler_id'));
        return self::returnData('flight', new FlightResource($flight), 'flight updated', 200);
    }

    public function destroy($id)
    {
        $this->authorize('delete', $id);
        $this->flight->delete($id);
        return self::success('flight deleted successfully', 200);
    }
}
