<?php

namespace App\Rules\password;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CheckSamePassword implements Rule
{
    public function passes($attribute, $value): bool
    {
        return !Hash::check($value, auth()->user()->password);
    }

    public function message(): string
    {
        return 'Your new password must be different from your current password';
    }
}
