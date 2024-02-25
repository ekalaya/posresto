<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();

        \App\Models\User::factory()->create([
             'name' => 'Ekalaya Manullang',
             'email' => 'ekalaya75@gmail.com',
             'password'=> Hash::make('12345678'),
             'role' => 'admin',
         ]);

         $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
         ]);
    }
}
