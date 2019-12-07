<?php

use App\Pp4;
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
        $count = Pp4::count();
        $zipcode = Pp4::where('id', rand(1, $count))->value('postcode');
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.nl',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
        ]);
        // wees consistent met inspringen: laat alle regels even veel inspringen
        User::create([
            'name' => 'Adman',
            'email' => 'adman@adman.nl',
            'password' => bcrypt('adman'),
            // 'zipcode' => DB::table('pp4')->where('id', rand(1, 4000))->value('postcode')->get().'AA',
            'zipcode' => $zipcode.chr(rand(65,90)).chr(rand(65,90)),
            'phonenr' => '0612345678',
            'isAdman' => true,
        ]);
        User::create([
            'name' => 'Adman2',
            'email' => 'adman2@adman.nl',
            'password' => bcrypt('adman2'),
            'phonenr' => '0687654321',
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
