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
    Schema::create('ojt_progress', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
        $table->integer('required_hours');
        $table->integer('accumulated_hours')->default(0);
        $table->integer('remaining_hours');
        $table->string('status');
    });
}

public function down(): void
{
    Schema::dropIfExists('ojt_progress');
}
};
