<?php

namespace App\Rules\user;

use Illuminate\Contracts\Validation\Rule;

class UserType implements Rule
{
    public function passes($attribute, $value): bool
    {
        return $value == 'traveler' || $value == 'sender';
    }

    public function message(): string
    {
        return 'user type should be traveler or sender';
    }
}
