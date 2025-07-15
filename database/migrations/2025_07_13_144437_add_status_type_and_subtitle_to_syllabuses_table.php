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
        Schema::table('syllabuses', function (Blueprint $table) {
            Schema::table('syllabuses', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title');
            $table->string('status')->default('draft')->after('hours');   // draft / published / archived
            $table->string('type')->default('video')->after('status');    // video / pdf / quiz ...
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syllabuses', function (Blueprint $table) {
               Schema::table('syllabuses', function (Blueprint $table) {
               $table->dropColumn(['subtitle', 'status', 'type']);
        });
        });
    }
};
