<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function resources()
    {
        return $this->morphedByMany(Resource::class, 'sourceable');
    }

    public function publications()
    {
        return $this->morphedByMany(Publication::class, 'sourceable');
    }
}
