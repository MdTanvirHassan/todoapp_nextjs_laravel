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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\Todo::create([
            'title' => 'Test Todo',
            'is_done' => 0
        ]);
        \App\Models\Contact::create([
            'name' => 'Tanvir Hassan',
            'email' => 'example@example.com',
            'phone' => '01925532372'
        ]);

        \App\Models\Employee::create([
            'name' => 'Tanvir Hassan',
            'email' => 'example@example.com',
            'phone' => '01925532372',
            'image' => 'No image to preview',
            'is_active' => 1
        ]);
    }
}
