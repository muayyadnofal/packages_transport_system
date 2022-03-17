<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Http\Requests\Traveler\ChangeStatuesRequest;
use App\Http\Resources\Sender\ReqResource;
use App\Http\Resources\Traveler\FlightResource;
use App\Repositories\Contracts\IFlight;
use App\Repositories\Contracts\IRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    use HttpResponse;

    private $flight, $req;

    public function __construct(IFlight $flight, IRequest $req)
    {
        $this->flight = $flight;
        $this->req = $req;
    }

    public function getMyFlightRequests($id): \Illuminate\Http\Response
    {
        $flight = $this->flight->findWhereFirst('id', $id);
        $this->authorize('getMyFlightRequests', $flight);
        $requests = $this->req->findWhere('flight_id', $flight->id);
        return self::returnData('requests', ReqResource::collection($requests), 'flight requests', 200);
    }

    public function changeRequestStatus(ChangeStatuesRequest $request, $id): \Illuminate\Http\Response
    {
        $req = $this->req->findWhereFirst('id', $id);
        $flight = $this->flight->findWhereFirst('id', $req->id);
        $this->authorize('changeRequestStatus', $flight);

        if ($request->status == 'in process') {
            $this->req->forceFill(['status' => 'in process'], $req->id);
            $this->flight->forceFill(['free_load_amount' => ($flight->free_load_amount - $req->full_weight)], $flight->id);
            return self::success('request accepted', 200);
        }

        $this->req->forceFill(['status' => 'fail'], $req->id);
        return self::success('request refused', 200);
    }

    public function getRequest($id): \Illuminate\Http\Response
    {
        $req = $this->req->findWhereFirst('id', $id);
        $flight = $this->flight->findWhereFirst('id', $req->id);
        $this->authorize('getRequest', $flight);
        return self::returnData('request', new ReqResource($req), 'flight request', 200);
    }
}
