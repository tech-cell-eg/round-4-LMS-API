<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusSeo extends Model
{
    protected $guarded = [];

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class);
    }


}
