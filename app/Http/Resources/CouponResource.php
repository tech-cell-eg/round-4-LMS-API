<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'instructor_id' => $this->instructor_id,
            'course_id' => $this->course_id,
            'coupon_status' => $this->coupon_status,
            'coupon_name' => $this->coupon_name,
            'description' => $this->description,
            'customer_group' => $this->customer_group,
            'coupon_category' => $this->coupon_category,
            'coupon_code' => $this->coupon_code,
            'uses_per_coupon' => $this->uses_per_coupon,
            'uses_per_customer' => $this->uses_per_customer,
            'priority' => $this->priority,
            'discount_type' => $this->discount_type,
            'discount_value' => (float) $this->discount_value, 
            'start_from' => $this->start_from,
            'end_at' => $this->end_at,
            'redemptions_count' => $this->whenLoaded('redemptionsCount', $this->redemptions_count, 0),
        ];
    }
}