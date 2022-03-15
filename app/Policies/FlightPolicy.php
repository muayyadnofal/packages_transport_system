<?php

namespace App\Policies;

use App\Models\Flight;
use App\Models\Traveler;use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlightPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Flight $flight)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(Traveler $traveler, Flight $flight): bool
    {
        return $flight->traveler_id === $traveler->id;
    }

    public function delete(Traveler $traveler, Flight $flight): bool
    {
        return $flight->traveler_id === $traveler->id;
    }

    public function restore(User $user, Flight $flight)
    {
        //
    }

    public function forceDelete(User $user, Flight $flight)
    {
        //
    }
}
