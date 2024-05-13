<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '081244445555',
            'isAdmin' => 1
        ]);

        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'handphone' => '081266667777',
            'isAdmin' => 0
        ]);

        // $this->call(CategorySeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(CartSeeder::class);
        // $this->call(InvoiceSeeder::class);
    }
}
