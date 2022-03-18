<?php

namespace App\Models;

use App\QueryFilters\Request\Search;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class Request extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function allRequests()
    {
        return app(Pipeline::class)
            ->send(Request::query())
            ->through([
                Search::class,
            ])
            ->thenReturn()
            ->get();
    }

    public function flight(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    public function packages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Package::class);
    }
}
