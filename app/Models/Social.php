<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $guarded = [];

    public function sociable()
    {
        return $this->morphTo();
    }
}
