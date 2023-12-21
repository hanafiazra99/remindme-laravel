<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@mail.com',
            'password'=>bcrypt("123456")
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Hanafi',
            'email' => 'hanafiazra@gmail.com',
            'password'=>bcrypt("123456")
        ]);
    }
}
