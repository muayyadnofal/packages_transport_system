<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Traveler\ChangeStatuesRequest;
use App\Http\Resources\Sender\ReqResource;
use App\Repositories\Contracts\IFlight;
use App\Repositories\Contracts\IRequest;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RequestController extends Controller
{
    use HttpResponse;

    protected $req, $flight, $traveler;

    public function __construct(IRequest $req, IFlight $flight, ITraveler $sender)
    {
        $this->req = $req;
        $this->flight = $flight;
        $this->traveler = $sender;
    }

    // get all system requests
    public function index(): \Illuminate\Http\Response
    {
        $requests = $this->req->all();
        return self::returnData('requests', ReqResource::collection($requests), 'all requests', 200);
    }

    // get requests for a sender
    public function getMyRequests(): \Illuminate\Http\Response
    {
        $requests = $this->req->findWhere('sender_id', auth()->user()->id);
        return self::returnData('requests', ReqResource::collection($requests), 'all requests', 200);
    }

    // get a request for a sender
    public function getRequestSender($id): \Illuminate\Http\Response
    {
        $req = $this->req->find($id);
        $this->authorize('getOne', $req);
        return self::returnData('request', new ReqResource($req), 'flight request', 200);
    }

    // get a request for a traveler
    public function getRequestTraveler($id): \Illuminate\Http\Response
    {
        $req = $this->req->find($id);
        $flight = $this->flight->find($req->id);
        $this->authorize('getRequest', $flight);
        return self::returnData('request', new ReqResource($req), 'flight request', 200);
    }

    // search to a request by full_weight and status
    public function applyFilters(): \Illuminate\Http\Response
    {
        $requests = $this->req->applyFilters();
        return self::returnData('requests', ReqResource::collection($requests), 'all requests', 200);
    }

    // create a request to a flight
    public function create($id): \Illuminate\Http\Response
    {
        $req = $this->flight->createRequest($id);
        return self::returnData('$request', new ReqResource($req), '$request created', 201);
    }

    // get traveler flight requests
    public function getMyFlightRequests($id): \Illuminate\Http\Response
    {
        $flight = $this->flight->find($id);
        $this->authorize('getMyFlightRequests', $flight);
        $requests = $this->req->findWhere('flight_id', $flight->id);
        return self::returnData('requests', ReqResource::collection($requests), 'flight requests', 200);
    }

    // delete request from the system
    public function destroy($id): \Illuminate\Http\Response
    {
        $req = $this->req->find($id);
        $flight = $this->flight->find($req->flight_id);
        $this->authorize('delete', $req);
        $this->req->delete($id);

        $notification_data = ['content' => 'the request you registered on your flight has been deleted'];
        $this->traveler->sendNotification($flight->traveler_id, $notification_data);
        return self::success('request deleted successfully', 200);
    }

    public function changeRequestStatusSender(ChangeStatuesRequest $request, $id): \Illuminate\Http\Response
    {
        $req = $this->req->find($id);
        $this->authorize('changeRequestStatusSender', $req);
        $flight = $this->flight->find($req->flight_id);
        $traveler = $this->traveler->find($flight->traveler_id);

        $notification_data = ['content' => "{$traveler->name} changed his request status to fail"];
        $this->req->forceFill(['status' => 'fail'], $req->id);
        $this->traveler->sendNotification($traveler->id, $notification_data);

        if ($request->status == 'fail' && $req->status == 'in process') {
            $this->flight->modifyFlightFreeAmount($req);
            return self::success('request failed', 200);
        }

        return self::success('request failed', 200);
    }

    public function changeRequestStatusTraveler(ChangeStatuesRequest $request, $id): \Illuminate\Http\Response
    {
        $req = $this->req->find($id);
        $flight = $this->flight->find($req->id);
        $this->authorize('changeRequestStatusTraveler', $flight);

        if ($request->status === 'in process' && $flight->free_load_amount >= $req->full_weight) {
            $this->req->forceFill(['status' => 'in process'], $req->id);
            $this->req->forceFill(['acceptance_Time' => Carbon::now()], $req->id);
            $this->flight->forceFill(['free_load_amount' => ($flight->free_load_amount - $req->full_weight)], $flight->id);
            return self::success('request accepted', 200);
        }

        $this->req->forceFill(['status' => 'fail'], $req->id);
        $this->req->forceFill(['fail_Time' => Carbon::now()], $req->id);
        return self::success('request refused', 200);
    }
}
