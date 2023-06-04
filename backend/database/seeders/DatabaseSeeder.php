<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\Products::factory(50)->create();
        $this->call(CountriesSeeder::class);
        $this->command->info('Seeded the countries!');
    }
}
