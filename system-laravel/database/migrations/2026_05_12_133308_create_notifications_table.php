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
        Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // student or supervisor id
        $table->string('user_type'); // 'student' or 'supervisor'
        $table->string('type'); // 'task_assigned', 'task_submitted', etc.
        $table->string('title');
        $table->text('message');
        $table->string('url')->nullable(); // link to view
        $table->boolean('is_read')->default(false);
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
