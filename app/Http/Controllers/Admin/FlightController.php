<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function destroy($id): \Illuminate\Http\Response
    {
        $this->flight->find($id);
        $this->flight->delete($id);
        return self::success('flight deleted successfully', 200);
    }
}
