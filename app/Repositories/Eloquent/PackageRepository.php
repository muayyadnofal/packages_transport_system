<?php

namespace App\Repositories\Eloquent;

use App\Models\Package;
use App\Repositories\Contracts\IPackage;

class PackageRepository extends BaseRepository implements IPackage
{
    public function model(): string
    {
        return Package::class;
    }
}
