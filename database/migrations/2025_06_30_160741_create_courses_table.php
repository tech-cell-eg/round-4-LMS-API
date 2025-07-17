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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('category_id')
            ->constrained('categories')
            ->onDelete('cascade');
            $table->foreignId('instructor_id')
            ->constrained('instructors')
            ->onDelete('cascade');
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->text('overview')->nullable();
            $table->text('description')->nullable();
            $table->text('certifications')->nullable();
            $table->json('languages')->nullable();
            $table->tinyInteger('levels')->default(0);
            $table->float('price')->default(0.00);
            $table->float('discount')->default(0.00);
            $table->float('tax')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
