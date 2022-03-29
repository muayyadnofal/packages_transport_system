<?php

namespace App\Repositories\Eloquent;

use App\Models\Request;
use App\Repositories\Contracts\IRequest;

class RequestRepository extends BaseRepository implements IRequest
{
    public function model(): string
    {
        return Request::class;
    }

    public function applyFilters()
    {
        return $this->model->allRequests();
    }

    public function deleteEmptyRequests() {
        foreach ($this->all() as $request) {
            if (count($request->packages) == 0) {
                $request->delete();
            }
        }
    }
}
