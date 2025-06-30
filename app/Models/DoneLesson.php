<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoneLesson extends Model
{
    protected $guarded = [];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
