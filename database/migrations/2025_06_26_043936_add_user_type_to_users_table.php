<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;   // ← add this

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['user', 'admin'])
                  ->default('user')
                  ->after('password');
        });

        // STEP 3 (automatic seeding) – call the seeder right after the column exists
        Artisan::call('db:seed', [
            '--class' => \Database\Seeders\AdminSeeder::class,
            '--force' => true,   // runs even in production, remove if you prefer safety
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
};
