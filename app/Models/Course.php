<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
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

     public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
     public function course_setting()
    {
        return $this->hasOne(Course_setting::class);
    }

}
