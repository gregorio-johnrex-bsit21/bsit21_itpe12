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
       Schema::create('student_profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    $table->string('school');
    $table->text('school_address');
    $table->text('home_address');
    $table->string('contact_number');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
