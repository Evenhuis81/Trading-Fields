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
        $this->call(CategoriesTableSeeder::class);
        $this->call(AdvertsTableSeeder::class);

        // $path = public_path().'/docs/4pp.sql';
        $path = 'https://raw.githubusercontent.com/bobdenotter/4pp/master/4pp.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('4pp table seeded!');
    }
}
