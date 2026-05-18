<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('guidelines')->nullable()->after('description');
            $table->date('deadline')->nullable()->after('guidelines');
            $table->integer('total_steps')->default(1)->after('deadline');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['guidelines', 'deadline', 'total_steps']);
        });
    }
};