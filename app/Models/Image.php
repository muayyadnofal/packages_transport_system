<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function imageable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function getImageAttribute(): array
    {
        return [
            'thumbnail' => $this->getImagePath('thumbnail'),
            'original' => $this->getImagePath('original'),
            'large' => $this->getImagePath('large')
        ];
    }

    private function getImagePath($size): string
    {
        return Storage::disk($this->disk)
            ->url("uploads/images/{$size}". $this->name);
    }
}
