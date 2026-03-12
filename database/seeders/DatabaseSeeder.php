<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $this->call(CategorySeeder::class);
        // $this->call(ProductSeeder::class);
        User::factory()->count(50)->create();

        // php artisan migrate:refresh --seed
    }
}
