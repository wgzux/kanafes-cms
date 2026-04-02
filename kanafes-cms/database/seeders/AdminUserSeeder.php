<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kanafest.vn'],
            [
                'name'     => 'Kanafest Admin',
                'email'    => 'admin@kanafest.vn',
                'password' => Hash::make('Admin@2025'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('✅ Admin user created: admin@kanafest.vn / Admin@2025');
    }
}
