<?php

namespace App\Providers;

use App\Repositories\Contracts\IFlight;
use App\Repositories\Contracts\IImage;
use App\Repositories\Contracts\IPackage;
use App\Repositories\Contracts\IRequest;
use App\Repositories\Contracts\IResetCodePassword;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\Repositories\Eloquent\FlightRepository;
use App\Repositories\Eloquent\ImageRepository;
use App\Repositories\Eloquent\PackageRepository;
use App\Repositories\Eloquent\RequestRepository;
use App\Repositories\Eloquent\ResetCodePasswordRepository;
use App\Repositories\Eloquent\SenderRepository;
use App\Repositories\Eloquent\TravelerRepository;
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
        $this->app->bind(IRequest::class, RequestRepository::class);
        $this->app->bind(IPackage::class, PackageRepository::class);
        $this->app->bind(ISender::class, SenderRepository::class);
        $this->app->bind(ITraveler::class, TravelerRepository::class);
        $this->app->bind(IResetCodePassword::class, ResetCodePasswordRepository::class);
        $this->app->bind(IImage::class, ImageRepository::class);
    }
}
