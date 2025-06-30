<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class);
    }
}
