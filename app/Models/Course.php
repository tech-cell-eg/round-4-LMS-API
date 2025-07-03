<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    protected $casts = [
       'languages' => 'array',
    ];

    public function instructor()
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
