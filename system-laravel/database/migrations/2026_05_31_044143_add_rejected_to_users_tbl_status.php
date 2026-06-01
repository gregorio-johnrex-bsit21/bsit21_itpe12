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
    DB::statement("ALTER TABLE `users_tbl` MODIFY `status` ENUM('Active', 'Inactive', 'Rejected')");
}

public function down(): void
{
    DB::statement("ALTER TABLE `users_tbl` MODIFY `status` ENUM('Active', 'Inactive')");
}
};
