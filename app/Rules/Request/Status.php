<?php

namespace App\Rules\Request;

use Illuminate\Contracts\Validation\Rule;

class Status implements Rule
{

    public function passes($attribute, $value): bool
    {
        return $value == 'waiting' || $value == 'in process' || $value == 'fail';
    }

    public function message(): string
    {
        return 'status should be waiting or in process or fail';
    }
}
