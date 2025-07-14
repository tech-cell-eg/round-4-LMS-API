<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model 
{
    use HasFactory; 

    protected $fillable = [
        'instructor_id',
        'course_id',
        'coupon_status',
        'coupon_name',
        'description',
        'customer_group',
        'coupon_category',
        'coupon_code',
        'uses_per_coupon',
        'uses_per_customer',
        'priority',
        'discount_type',
        'discount_value',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
    ];


    /**
     * Get the instructor that owns the Coupon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor()
    {
        // الكوبون ده بيتبع Instructor واحد
        // instructor_id في جدول الكوبونات بيربط بالـ id بتاع الـ Instructor
        return $this->belongsTo(Instructor::class);
    }

    /**
     * Get the course that the Coupon is for.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        // الكوبون ده ممكن يكون لكورس واحد (أو لا شيء لو هو عام)
        // course_id في جدول الكوبونات بيربط بالـ id بتاع الـ Course
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the redemptions for the Coupon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function redemptions()
    {
        return $this->hasMany(CouponRedemption::class);
    }

    //  لو عايز دايماً الكود يتخزن بحروف كبيرة (uppercase)
    // public function setCouponCodeAttribute($value)
    // {
    //     $this->attributes['coupon_code'] = strtoupper($value);
    // }

    // او لو عايز اجيب تاريخ صلاحية الكوبون كامل  Carbon instance
    // public function getExpiresAtAttribute()
    // {
    //     return \Carbon\Carbon::parse($this->end_date . ' ' . $this->end_time);
    // }
}