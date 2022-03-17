<?php

namespace App\Repositories\Contracts;

interface IResetCodePassword
{
    public function findAndDelete($column, $value);
}
