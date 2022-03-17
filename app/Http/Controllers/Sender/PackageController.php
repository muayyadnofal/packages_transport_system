<?php

namespace App\Http\Controllers\Sender;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sender\PackageRequest;
use App\Http\Requests\Sender\ReqRequest;
use App\Http\Resources\Sender\PackageResource;
use App\Http\Resources\Sender\ReqResource;
use App\Http\Resources\Traveler\FlightResource;
use App\Repositories\Contracts\IFlight;
use App\Repositories\Contracts\IPackage;
use App\Repositories\Contracts\IRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    use HttpResponse;

    protected $package, $req, $flight;

    public function __construct(IPackage $package, IRequest $req, IFlight $flight)
    {
        $this->package = $package;
        $this->req = $req;
        $this->flight = $flight;
    }

    public function index(): \Illuminate\Http\Response
    {
        $requests = $this->package->all();
        return self::returnData('packages', PackageResource::collection($requests), 'all packages', 200);
    }

    public function create(PackageRequest $request, $id): \Illuminate\Http\Response
    {
        $req = $this->req->find($id);
        $flight = $this->flight->find($req->flight_id);

        if ($flight->free_load_amount < $request->weight) {
            return self::failure('weight is bigger than the traveler free amount', 422);
        }

        $data = array_merge($request->all(), ['request_id' => $req->id]);
        $package = $this->package->create($data);
        $this->flight->forceFill(['free_load_amount' => ($flight->free_load_amount - $request->weight)], $id);
        return self::returnData('package', new PackageResource($package), '$package created', 201);
    }
}
