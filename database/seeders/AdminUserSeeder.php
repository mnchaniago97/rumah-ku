<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@rumahku.test'],
            [
                'name' => 'Admin Rumah IO',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'is_active' => true,
                'phone' => '08123456789',
                'bio' => 'Administrator',
                'timezone' => 'Asia/Jakarta',
                'language' => 'id',
                'theme' => 'light',
                'notifications_email' => true,
                'notifications_sms' => false,
            ]
        );
    }
}
