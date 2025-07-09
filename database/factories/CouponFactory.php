<?php

namespace Database\Factories;

use App\Models\Coupon;
use App\Models\Instructor;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // لاستخدام Str::random
use Carbon\Carbon;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 week'); // تبدأ من شهر فات ليوم واحد في المستقبل
        $endDate = $this->faker->dateTimeBetween($startDate, Carbon::parse($startDate)->addMonths(3)); // تنتهي بعد 3 أشهر كحد أقصى من البداية

        $discountType = $this->faker->randomElement(['percentage', 'fixed_amount']);
        $discountValue = ($discountType === 'percentage') ? $this->faker->numberBetween(5, 50) : $this->faker->numberBetween(10, 100);

        return [
            'instructor_id' => rand(1,5),
            'course_id' => rand(1,5),
            'coupon_name' => $this->faker->word() . ' Discount',
            'coupon_code' => Str::upper(Str::random(10)), // كود عشوائي بـ 10 حروف كبيرة
            'description' => $this->faker->sentence(),
            'coupon_status' => $this->faker->randomElement(['active', 'inactive', 'scheduled']),
            'customer_group' => $this->faker->randomElement(['general', 'specific_users']),
            'coupon_category' => $this->faker->randomElement(['specific_coupon', 'general_promotion']),
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'uses_per_coupon' => $this->faker->numberBetween(50, 500),
            'uses_per_customer' => $this->faker->numberBetween(1, 5),
            'start_from' => Carbon::instance($startDate)->toDateTimeString(), // "Y-m-d H:i:s"
            'end_at' => Carbon::instance($endDate)->toDateTimeString(),

            'priority' => $this->faker->numberBetween(0, 10),
        ];
    }
}