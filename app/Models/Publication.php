<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sources()
    {
        return $this->morphToMany(Source::class, 'sourceable')->withPivot(['catalog_number', 'lot_number']);
    }

    public function resources()
    {
        return $this->morphedByMany(Resource::class, 'publicationable');
    }
}
