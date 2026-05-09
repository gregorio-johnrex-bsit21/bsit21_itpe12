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
        if (!Schema::hasTable('users_tbl')) {
            Schema::create('users_tbl', function (Blueprint $table) {
                $table->id();
                $table->string('supervisor_id', 10)->unique()->nullable();
                $table->string('student_id', 10)->unique()->nullable();
                $table->string('company_id', 10)->nullable();
                $table->foreign('company_id')->references('company_id')->on('company_tbl')->onDelete('cascade');
                $table->string('name');
                $table->string('password');
                $table->enum('role', ['admin', 'supervisor', 'student']);
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->timestamps();
            });
        }
    }
};