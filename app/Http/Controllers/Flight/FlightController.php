<?php

namespace App\Http\Controllers\Flight;

use App\Http\Controllers\Controller;
use App\Http\Requests\Traveler\FlightRequest;
use App\Http\Resources\Traveler\FlightResource;
use App\Repositories\Contracts\IFlight;
use App\Repositories\Contracts\IRequest;
use App\Repositories\Contracts\ISender;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    use HttpResponse;

    protected $flight, $req, $sender;

    public function __construct(IFlight $flight, IRequest $req, ISender $sender)
    {
        $this->flight = $flight;
        $this->req = $req;
        $this->sender = $sender;
    }

    // get all system flights
    public function index(): \Illuminate\Http\Response
    {
        $flights = $this->flight->all();
        return self::returnData('flights', FlightResource::collection($flights), 'all flights', 200);
    }

    // search flights by its landing/launch city
    public function applyFilters(): \Illuminate\Http\Response
    {
        $flights = $this->flight->applyFilters();
        return self::returnData('flights', FlightResource::collection($flights), 'all flights', 200);
    }

    // get authenticated traveler flights
    public function getMyFlights(): \Illuminate\Http\Response
    {
        $flights = $this->flight->findWhere('traveler_id', auth()->user()->id);
        return self::returnData('flights', FlightResource::collection($flights), 'all flights', 200);
    }

    // create a flight
    public function create(FlightRequest $request): \Illuminate\Http\Response
    {
        $data = array_merge($request->all(), ['traveler_id' => auth()->user()->id]);
        $flight = $this->flight->create($data);
        return self::returnData('flight', new FlightResource($flight), 'flight created', 201);
    }

    // update flight info
    public function update(Request $request, $id): \Illuminate\Http\Response
    {
        $senders = [];
        $flight = $this->flight->find($id);
        $requests = $this->req->findWhere('flight_id', $id);
        $this->authorize('update', $flight);
        $flight = $this->flight->update($id, $request->all());

        foreach ($requests as $req) {
            $senders = $this->sender->findWhere('id', $req->sender_id);
        }

        $notification_data = ['content' => 'the flight you requested has been updated'];

        foreach ($senders as $sender) {
            $this->sender->sendNotification($sender->id, $notification_data);
        }
        return self::returnData('flight', new FlightResource($flight), 'flight updated', 200);
    }

    // delete flight from the system
    public function destroy($id): \Illuminate\Http\Response
    {
        $flight = $this->flight->find($id);
        $requests = $this->req->findWhere('flight_id', $id);
        $senders = [];

        $this->authorize('delete', $flight);

        foreach ($requests as $req) {
            $senders = $this->sender->findWhere('id', $req->sender_id);
        }

        $notification_data = ['content' => 'the flight you requested has been deleted'];

        foreach ($senders as $sender) {
            $this->sender->sendNotification($sender->id, $notification_data);
        }
        $this->flight->delete($id);

        return self::success('flight deleted successfully', 200);
    }
}
