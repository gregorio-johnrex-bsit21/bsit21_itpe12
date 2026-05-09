<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users_tbl')->onDelete('cascade');
    $table->string('student_id')->unique();
    $table->string('company_id', 10); // ← change to string
    $table->timestamps();
});
}

public function down()
{
    Schema::dropIfExists('students');
}
};
