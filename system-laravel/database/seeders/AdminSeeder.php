<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserTbl;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = UserTbl::create([
            'name' => 'System Admin',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
            'status' => 'Active',
        ]);

        Admin::create([
            'user_id' => $user->id,
            'admin_code' => 'ADM001',
        ]);
    }
}