<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function publications()
    {
        return $this->morphToMany(Publication::class, 'publicationable')->withPivot('notes');
    }

    public function sources()
    {
        return $this->morphToMany(Source::class, 'sourceable')->withPivot(['catalog_number', 'lot_number']);
    }
}
