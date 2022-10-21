<?php

namespace Database\Seeders;

use Database\Factories\roleFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();
        // $this->call(RoleSeeder::class);
        $this->call(InsuranceSeeder::class);
    }
}
