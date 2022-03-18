<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function destroy($id): \Illuminate\Http\Response
    {
        $this->req->find($id);
        $this->req->delete($id);
        return self::success('request deleted successfully', 200);
    }
}
