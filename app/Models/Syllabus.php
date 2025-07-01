<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    protected $guarded = [];
    protected $table = 'syllabuses';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
