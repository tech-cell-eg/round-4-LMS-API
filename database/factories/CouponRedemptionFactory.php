<?php

namespace Database\Factories;

use App\Models\CouponRedemption;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class CouponRedemptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CouponRedemption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // التأكد من وجود Coupon واحد على الأقل
        // (يمكنك تعديل هذا لجلب كوبون موجود بدلاً من إنشاء واحد جديد في كل مرة)
        $coupon = Coupon::factory()->create();

        // التأكد من وجود User واحد على الأقل
        // (يمكنك تعديل هذا لجلب مستخدم موجود بدلاً من إنشاء واحد جديد في كل مرة)
        $user = User::factory()->create();

        // تاريخ الاستخدام سيكون بين تاريخ بدء الكوبون وتاريخ انتهائه
        $redemptionDate = $this->faker->dateTimeBetween($coupon->start_date, $coupon->end_date);

        // قيمة الخصم المطبقة (يمكن أن تكون هي نفس discount_value في الكوبون، أو يتم حسابها)
        $discountAmount = $coupon->discount_value;

        return [
            'coupon_id' => $coupon->id,
            'user_id' => $user->id,
            'discount_amount_applied' => $discountAmount,
            'redemption_date' => $redemptionDate,
            'created_at' => $redemptionDate, 
            'updated_at' => $redemptionDate,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (CouponRedemption $redemption) {
            //
        })->afterCreating(function (CouponRedemption $redemption) {
            // تحديث عدد مرات استخدام الكوبون بعد كل عملية استرداد
            // وهذا يفرض أن الكوبون ليس له عدد استخدامات غير محدود (uses_per_coupon ليس null)
            if ($redemption->coupon->uses_per_coupon !== null) {
                $redemption->coupon->decrement('uses_per_coupon');
            }
        });
    }
}