<?php

namespace App\Repositories\Contracts;

interface IFlight
{
    public function createRequest($id);
    public function modifyFlightFreeAmount($request);
}
