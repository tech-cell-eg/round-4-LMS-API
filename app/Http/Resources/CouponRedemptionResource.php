<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; 

class CouponRedemptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'coupon_id' => $this->coupon_id,
            'user_id' => $this->user_id,
            'discount_amount_applied' => (float) $this->discount_amount_applied,
            'redemption_date' => Carbon::parse($this->redemption_date)->format('Y-m-d H:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),

            // تضمين بيانات المستخدم الذي استخدم الكوبون (إذا تم تحميل العلاقة)
            // نستخدم whenLoaded للتأكد من أن العلاقة محملة بالفعل قبل محاولة الوصول إليها
            'user' => [
                'id' => $this->whenLoaded('user', $this->user->id),
                'name' => $this->whenLoaded('user', $this->user->name),
                'email' => $this->whenLoaded('user', $this->user->email),
            ],

            'coupon' => new CouponResource($this->whenLoaded('coupon')),
        ];
    }
}