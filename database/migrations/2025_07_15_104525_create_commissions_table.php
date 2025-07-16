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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')
                ->constrained('instructors')
                ->onDelete('cascade'); // صاحب الكورس
            $table->foreignId('course_id')
                ->constrained('courses')
                ->onDelete('cascade'); // الكورس اللي عليه العمولة
            $table->foreignId('payment_id')
                ->constrained('payments')
                ->onDelete('cascade'); // عملية الدفع المرتبطة
            $table->float('amount'); // قيمة العمولة
            $table->enum('status', ['pending', 'received'])
                ->default('pending'); // حالة العمولة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
