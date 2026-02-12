<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class FakeUsersSeeder extends Seeder
{
    public function run(): void
    {
        /** @var Faker $faker */
        $faker = app(Faker::class);

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name'              => $faker->name,
                'email'             => $faker->unique()->safeEmail,
                'password'          => Hash::make('password'),   // all test users share “password”
                'email_verified_at' => now(),
                'is_verified'       => true,
                'user_type'         => 'user',
            ]);
        }
    }
}
