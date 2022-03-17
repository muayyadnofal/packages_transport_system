<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function flight(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    public function packages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Package::class);
    }
}
