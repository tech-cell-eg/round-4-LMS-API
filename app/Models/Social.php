<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Social extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sociable()
    {
        return $this->morphTo();
    }
}
