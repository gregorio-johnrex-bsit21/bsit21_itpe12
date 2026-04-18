<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserTbl; // Ensure this matches your model name
use Illuminate\Support\Facades\Hash;

class UserTblSeeder extends Seeder
{
    public function run(): void
{
    UserTbl::updateOrCreate(
        ['student_id' => 'ADMIN-01'], // Search for this
        [
            'name'     => 'System Admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'status'   => 'approved',
        ]
    );
}
}