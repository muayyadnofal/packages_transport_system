<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Policies\FlightPolicy;
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

    public function getMyFlights(): \Illuminate\Http\Response
    {
        $flights = $this->flight->findWhere('traveler_id', auth()->user()->id);
        return self::returnData('flights', FlightResource::collection($flights), 'all flights', 200);
    }

    public function create(FlightRequest $request): \Illuminate\Http\Response
    {
        $data = array_merge($request->all(), ['traveler_id' => auth()->user()->id]);
        $flight = $this->flight->create($data);
        return self::returnData('flight', new FlightResource($flight), 'flight created', 201);
    }

    public function update(Request $request, $id): \Illuminate\Http\Response
    {
        $flight = $this->flight->find($id);
        $this->authorize('update', $flight);
        $flight = $this->flight->update($id, $request->all());
        return self::returnData('flight', new FlightResource($flight), 'flight updated', 200);
    }

    public function destroy($id): \Illuminate\Http\Response
    {
        $flight = $this->flight->find($id);
        $this->authorize('delete', $flight);
        $this->flight->delete($id);
        return self::success('flight deleted successfully', 200);
    }
}
