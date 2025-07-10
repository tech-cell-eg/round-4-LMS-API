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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            // ربط الكوبون بالـ Instructor اللي أنشأه
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            // ربط الكوبون بالكورس (اختياري، ممكن يكون الكوبون عام)
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');

            $table->string('coupon_status')->default('draft'); // 'active', 'inactive', 'draft', 'scheduled', 'expired'
            $table->string('coupon_name');
            $table->text('description')->nullable();
            $table->string('customer_group')->default('general'); // 'general', 'specific_users'
            $table->string('coupon_category')->default('specific_coupon'); // 'specific_coupon', 'general_promotion'
            $table->string('coupon_code')->unique(); // الكود هيكون فريد لكل كوبون
            // $table->boolean('auto_generate_code')->default(false); // ممكن تتجاهل ده مؤقتاً لو الـ front-end هيتحكم في توليد الكود
            $table->integer('uses_per_coupon')->nullable(); // العدد الكلي للاستخدام المسموح به للكوبون ده
            $table->integer('uses_per_customer')->nullable(); // العدد الأقصى لاستخدام الكوبون لكل عميل

            $table->integer('priority')->default(0); // أولوية الكوبون لو فيه أكتر من واحد ممكن يتطبق

            $table->string('discount_type'); // 'percentage' or 'fixed_amount'
            $table->decimal('discount_value', 8, 2); // قيمة الخصم

            $table->timestamp('start_from')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};