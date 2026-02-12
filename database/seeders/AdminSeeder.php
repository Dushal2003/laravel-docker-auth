<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'DushalAdmin123@gmail.com'],   // ← exact admin ID
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make('12345678'),  // ← exact password
                'email_verified_at' => now(),
                'is_verified' => true,
                'user_type'         => 'admin',
            ]
        );
    }
}
