<?php

use App\Condition;
use Illuminate\Database\Seeder;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condition::create([
            'name' => "New",
        ]);
        Condition::create([
            'name' => "As good as new",
        ]);
        Condition::create([
            'name' => "Used",
        ]);
    }
}
