<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Syllabus extends Model
{
    use HasFactory;
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

    public function resources()
    {
        return $this->hasOne(SyllabusResource::class);
    }

    public function seo()
    {
        return $this->hasOne(SyllabusSeo::class);
    }



}
