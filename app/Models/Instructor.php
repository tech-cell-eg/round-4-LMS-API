<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function social()
    {
        return $this->morphOne(Social::class, 'sociable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'senderable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
