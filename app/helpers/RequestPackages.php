<?php

namespace App\helpers;

use App\Repositories\Contracts\IPackage;
use App\Repositories\Eloquent\PackageRepository;

class RequestPackages
{
    protected $package;

    public function __construct()
    {
        $this->package = new PackageRepository();
    }

    public function getRequestPackages($id)
    {
        return $this->package->findWhere('request_id', $id);
    }
}
