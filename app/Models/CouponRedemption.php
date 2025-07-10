<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponRedemption extends Model
{
    use HasFactory;

    protected $table = 'coupon_redemptions';

    protected $fillable = [
        'coupon_id',
        'user_id',
        'discount_amount_applied',
        'redemption_date',
    ];


       /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'redemption_date' => 'datetime',
        'discount_amount_applied' => 'decimal:2',
    ];

    /**
     * Get the coupon that was redeemed.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the user (student) who redeemed the coupon.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}