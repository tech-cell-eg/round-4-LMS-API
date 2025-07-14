<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course_setting extends Model
{
    protected $fillable = [
        'course_id',
        'status',
        'requirements',
        'target_audience',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
