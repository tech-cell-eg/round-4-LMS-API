<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupon_redemptions', function (Blueprint $table) {
            $table->id();
            // ربط عملية الاستخدام بالكوبون اللي تم استخدامه
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
            // ربط عملية الاستخدام بالمستخدم (الطالب) اللي استخدم الكوبون
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // الطالب هو User

            $table->decimal('discount_amount_applied', 8, 2); // قيمة الخصم اللي اتطبقت فعلاً في عملية الشراء دي
            $table->timestamp('redemption_date')->useCurrent(); // تاريخ ووقت استخدام الكوبون، وتسجيل الوقت الحالي تلقائيًا

            $table->timestamps(); // created_at و updated_at

            // هذا القيد يضمن أن المستخدم الواحد لا يمكنه استخدام نفس الكوبون أكثر من مرة واحدة.
            // وده بيحقق شرط "لمرة واحدة بس" لكل طالب.
            $table->unique(['coupon_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_redemptions');
    }
};