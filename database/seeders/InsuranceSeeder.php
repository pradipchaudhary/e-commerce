<?php

namespace Database\Seeders;

use App\Models\setting\insurance;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        insurance::create([
            'status' => true,
            'description'=> 'Yes, insure for the full amount of the order',
            'percent' => 1
        ]);

        insurance::create([
            'status' => false,
            'description'=> 'No, I will take responsibility for any lost, stolen, or damaged items',
            'percent' => 0
        ]);
    }
}
