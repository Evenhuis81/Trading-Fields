<?php

use App\Advert;
use App\Picture;
use Illuminate\Database\Seeder;

class AdvertsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Advert::class,30)->create();
        $adverts=Advert::all();
        $pictures = array('advertseederimages/Auto.jpg', 'advertseederimages/Fiets.jpg', 'advertseederimages/Horloge.jpg', 'advertseederimages/Magnetron.jpg', 'advertseederimages/Monitor.jpg', 'advertseederimages/Naafdoppen.jpg', 'advertseederimages/Phone.jpg', 'advertseederimages/Piano.jpg', 'advertseederimages/Schoen.jpg', 'advertseederimages/Slijpmachine.jpg', 'advertseederimages/Stoel.jpg', 'advertseederimages/Wasmachine.jpg', );
        foreach ($adverts as $advert) { 
            $img = Picture::create([
                'filename' => $pictures[rand(0, 11)],
                'owner_id' => $advert->owner_id,
                'advert_id' => $advert->id,
            ]);
        }
    }
}
