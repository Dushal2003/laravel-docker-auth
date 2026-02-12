<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Faker\Generator as Faker;

class FakeTasksSeeder extends Seeder
{
    public function run(): void
    {
        $faker = app(Faker::class);

        for ($i = 0; $i < 10; $i++) {
            Task::create([
                'title'            => $faker->sentence(3),
                'description'      => $faker->sentence(6),
                'long_description' => $faker->paragraph(3),
                'completed'        => $faker->boolean(50), // 50% chance true/false
            ]);
        }
    }
}
