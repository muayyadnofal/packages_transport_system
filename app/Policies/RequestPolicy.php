<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Request $request)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function getOne(Sender $sender, Request $request): bool
    {
        return $request->sender_id === $sender->id;
    }

    public function update(Sender $sender, Request $request): bool
    {
        return $request->sender_id === $sender->id;
    }

    public function delete(Sender $sender, Request $request): bool
    {
        return $request->sender_id === $request->id;
    }

    public function restore(User $user, Request $request)
    {
        //
    }

    public function forceDelete(User $user, Request $request)
    {
        //
    }
}
