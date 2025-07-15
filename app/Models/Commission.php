<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'course_id',
        'payment_id',
        'amount',
        'status',
    ];

    
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

 
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

   
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
