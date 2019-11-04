<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.nl',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
        ]);
        User::create([
        'name' => 'Adman',
        'email' => 'adman@adman.nl',
        'password' => bcrypt('adman'),
        'isAdman' => true,
        ]);
        User::create([
            'name' => 'Adman2',
            'email' => 'adman2@adman.nl',
            'password' => bcrypt('adman2'),
            'isAdman' => true,
        ]);
        User::create([
            'name' => 'Guest',
            'email' => 'guest@guest.nl',
            'password' => bcrypt('guest'),
            'isGuest' => true,
        ]);

    }
}
