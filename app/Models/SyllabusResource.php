<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusResource extends Model
{
    protected $guarded = [];

    protected $table = 'syllabus_resources';

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class);
    }

}
