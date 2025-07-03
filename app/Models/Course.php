<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
       'languages' => 'array',
    ];

    public function instructors()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function syllabuses()
    {
        return $this->hasMany(Syllabus::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }


    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }


}
