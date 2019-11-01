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
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.nl',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
        ]);
        $user = User::create([
        'name' => 'Adman',
        'email' => 'adman@adman.nl',
        'password' => bcrypt('adman'),
        'isAdman' => true,
        ]);
        $user = User::create([
            'name' => 'Guest',
            'email' => 'guest@guest.nl',
            'password' => bcrypt('guest'),
            'isGuest' => true,
        ]);
    }
}
