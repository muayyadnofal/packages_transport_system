<?php

namespace App\Http\Controllers\Sender;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sender\ReqRequest;
use App\Http\Resources\Sender\ReqResource;
use App\Repositories\Contracts\IFlight;
use App\Repositories\Contracts\IRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    use HttpResponse;

    protected $req, $flight;

    public function __construct(IRequest $req, IFlight $flight)
    {
        $this->req = $req;
        $this->flight = $flight;
    }

    public function index(): \Illuminate\Http\Response
    {
        $requests = $this->req->all();
        return self::returnData('requests', ReqResource::collection($requests), 'all requests', 200);
    }

    public function getMyRequests(): \Illuminate\Http\Response
    {
        $requests = $this->req->findWhere('sender_id', auth()->user()->id);
        return self::returnData('requests', ReqResource::collection($requests), 'all requests', 200);
    }

    public function getRequest($id): \Illuminate\Http\Response
    {
        $req = $this->req->find($id);
        $this->authorize('getOne', $req);
        return self::returnData('request', new ReqResource($req), 'my request', 200);
    }

    public function create(Request $request, $id): \Illuminate\Http\Response
    {
        $flight = $this->flight->find($id);
        $data = array_merge($request->all(), ['sender_id' => auth()->user()->id, 'flight_id' => $flight->id]);
        $req = $this->req->create($data);
        return self::returnData('$request', new ReqResource($req), '$request created', 201);
    }

    public function destroy($id): \Illuminate\Http\Response
    {
        $req = $this->req->find($id);
        $this->authorize('delete', $req);
        $this->req->delete($id);
        return self::success('request deleted successfully', 200);
    }
}
