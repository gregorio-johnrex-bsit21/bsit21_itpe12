<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_ojt_requirements', function (Blueprint $table) {
            $table->id();

            // Fixed: unsignedBigInteger to match company_tbl.id (bigint unsigned)
            // Fixed: references 'company_tbl' not 'companies'
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_tbl')->onDelete('cascade');

            $table->time('am_start_time')->nullable();
            $table->time('am_end_time')->nullable();
            $table->time('pm_start_time')->nullable();
            $table->time('pm_end_time')->nullable();
            $table->integer('required_hours')->default(480);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->unique('company_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_ojt_requirements');
    }
};