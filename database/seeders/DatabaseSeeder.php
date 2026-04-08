<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Band::factory(50)->create();
        // $this->call(BandSeeder::class);

        User::factory()->create([
            'name' => '管理者',
            'email' => 'test@example.com',
            'password' => Hash::make('testtest'),
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test1@example.com',
            'password' => Hash::make('testtest1'),
        ]);
    }
}
