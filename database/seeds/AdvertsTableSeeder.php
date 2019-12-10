<?php

use App\Advert;
use App\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AdvertsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Advert::class,4699)->create();
        $adverts = Advert::all();
        // $pictures = array('advertseederimages/Auto.jpg', 'advertseederimages/Fiets.jpg', 'advertseederimages/Horloge.jpg', 'advertseederimages/Magnetron.jpg', 'advertseederimages/Monitor.jpg', 'advertseederimages/Naafdoppen.jpg', 'advertseederimages/Phone.jpg', 'advertseederimages/Piano.jpg', 'advertseederimages/Schoen.jpg', 'advertseederimages/Slijpmachine.jpg', 'advertseederimages/Stoel.jpg', 'advertseederimages/Wasmachine.jpg', );
        $picArr = Storage::files('/public/advertseederimages');
        foreach ($adverts as $advert) { 
            // onderstaande code kan tot errors leiden want index van picArr is op willekeurig getal gebaseerd die los staat van werkelijk aantal aanwezige plaatjes!
            $randNr = rand(0, count($picArr)-1);
            // gebruik duidelijke te begrijpen variabele namen die ook voor andere programmeurs te begrijpen zijn, bijv. image i.p.v. imag of nme
            // $image = Storage::get($picArr[$randNr]);
            $imgname = explode('/', $picArr[$randNr]);
            $picture = Picture::create([
            //     'file_name' => 'advertimages/'.date('YmdHis',time()).rand(0,99999).'-'.$imgname[2],
            //     'owner_id' => $advert->owner_id,
            //     'advert_id' => $advert->id,
                'file_name' => 'advertseederimages/'.$imgname[2],
                'owner_id' => $advert->owner_id,
                'advert_id' => $advert->id,
            ]);
            // Storage::disk('public')->put($picture['file_name'], $image);
            $advert->categories()->sync([rand(1,5)]);
        }
    }
}
