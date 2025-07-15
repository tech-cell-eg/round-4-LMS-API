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
     Schema::create('course_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['open', 'closed', 'upcoming'])->default('open'); // حالة الكورس
            $table->text('requirements')->nullable(); // متطلبات الكورس
            $table->text('target_audience')->nullable(); // لمن هو الكورس
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_settings');
    }
};
