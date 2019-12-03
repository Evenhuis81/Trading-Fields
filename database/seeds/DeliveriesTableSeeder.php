<?php

use App\Delivery;
use Illuminate\Database\Seeder;

class DeliveriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Delivery::create([
            'name' => "Collect",
        ]);
        Delivery::create([
            'name' => "Dispatch",
        ]);
        Delivery::create([
            'name' => "Collect or Dispatch",
        ]);
    }
}
