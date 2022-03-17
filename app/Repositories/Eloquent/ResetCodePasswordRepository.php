<?php

namespace App\Repositories\Eloquent;

use App\Models\ResetCodePassword;
use App\Repositories\Contracts\IResetCodePassword;

class ResetCodePasswordRepository extends BaseRepository implements IResetCodePassword
{
    public function model(): string
    {
        return ResetCodePassword::class;
    }

    public function findAndDelete($column, $value)
    {
        $this->model->where($column, $value)->delete();
    }
}
