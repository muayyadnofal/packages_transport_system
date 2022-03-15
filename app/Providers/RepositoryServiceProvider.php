<?php

namespace App\Providers;

use App\Repositories\Contracts\IFlight;
use App\Repositories\Eloquent\FlightRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->bind(IFlight::class, FlightRepository::class);
    }
}
