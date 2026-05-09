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
    Schema::create('users_tbl', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('password');
        $table->enum('role', ['Admin', 'Supervisor', 'Student']);
        $table->enum('status', ['Active', 'Inactive'])->default('Active');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('users_tbl');
}
};
