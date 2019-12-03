<?php

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
        $this->call(UsersTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(AdvertsTableSeeder::class);
        // plaats postcode import in eigen / aparte seeder class  ==>>   Made migration (else DB:rename doesn't work inside seeder, makes copy)
    }
}
