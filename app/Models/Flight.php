<?php

namespace App\Models;

use App\QueryFilters\Flight\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class Flight extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function allFlights()
    {
        return app(Pipeline::class)
            ->send(Flight::query())
            ->through([
                Search::class,
            ])
            ->thenReturn()
            ->get();
    }

    public function requests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Request::class);
    }
}
