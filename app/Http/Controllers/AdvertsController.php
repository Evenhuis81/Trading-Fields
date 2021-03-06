<?php

namespace App\Http\Controllers;

use App\Bid;
use App\User;
use App\Advert;
use App\Picture;

use App\Category;
use App\Delivery;
use App\Condition;
use App\Events\AdvertCreated;
use App\Http\Controllers\Controller;
use App\Repositories\AdvertRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdvertStoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AdvertUpdateRequest;

// use Illuminate\Http\Request;

class AdvertsController extends Controller
{  
    private $advertRepository;

    public function __construct(AdvertRepository $advertRepository)
    {
        $this->advertRepository = $advertRepository;
        $this->middleware('adman')->except(['show']);
    }

    public function index()
    {
        $adverts = $this->advertRepository->getByUser();
        return view('adverts.index', compact('adverts'));
    }
    public function create()
    {
        // Bound to view: Categories (ComposerServiceProvider->CategoryComposer)
        $deliveries = Delivery::all();
        $conditions = Condition::all();
        return view('adverts.create', compact('deliveries', 'conditions'));
    }
    public function store(AdvertStoreRequest $request)
    {
        $validated = $request->validated();
        // Make zipcode letters uppercase and save it in user table if zipcode null (aka 1st time input)
        $zip = $this->zipcode($validated['zipcode']);
        $zipcode = substr($zip, 0, 4);
        $zipletters = substr($zip, 4, 6);
        $validated['zipcode'] = $zipcode;
        $validated['zipletters'] = $zipletters;
        // onderstaande code levert error op: Undefined variable: advert  ==>>  Create Advert must be before storeimage cause it needs advertid
        $advert = Advert::create($validated);
        $this->storeImage($validated, $advert->id);
        $advert->categories()->sync($validated['category']);


        event(new AdvertCreated($advert));


        return redirect('/adverts/create')->with('success', 'Successfully Create New Advert!')
                                            ->with('advertid', $advert->id);
    }
    public function zipcode($zip)
    {
        $zipcode = strtoupper($zip);
        if (auth()->user()->zipcode===null) {
            User::find(auth()->user()->id)->update(['zipcode' => $zipcode]);
        }
        return $zipcode;
    }
    public function show(Advert $advert)
    {
        $this->startbidCheck($advert);
        if(session('guestbid')) {
            if ($advert->owner_id == auth()->id()) {
                session()->flash('nobidforowner', 'You can\'t bid on your own Advert!');
            }
        } else {
            views($advert)->record();
        }
        
        return view('adverts.show', ['advert' => $advert]);
    }
    public function edit(Advert $advert)
    {
        $deliveries = Delivery::all();
        $conditions = Condition::all();
        // Bound to view: Categories (ComposerServiceProvider->CategoryComposer)
        $this->authorize('update', $advert);
        $base64Img = $this->convertBase64($advert);
        return view('adverts.edit', compact('advert', 'base64Img', 'deliveries', 'conditions'));
    }
    public function update(AdvertUpdateRequest $request, Advert $advert)
    {
        $validated = $request->validated();
        $zip = $this->zipcode($validated['zipcode']);
        $zipcode = substr($zip, 0, 4);
        $zipletters = substr($zip, 4, 6);
        $validated['zipcode'] = $zipcode;
        $validated['zipletters'] = $zipletters;
        $this->updateImage($validated, $advert);
        $advert->update($validated);
        $advert->categories()->sync([$validated['category']]);
        return redirect('adverts/'.$advert->id.'/edit')->with('success', 'You have successfully edited your Advert!')
                                                        ->with('startbid', "0");
    }
    public function destroy(Advert $advert)
    {
        $this->authorize('update', $advert);
        $this->deleteImage($advert);
        $advert->delete();
    }
    public function storeImage($val, $id)
    {
        if (isset($val['images']) && isset($val['imagename'])) {
            foreach ($val['images'] as $image) {
                $name = $image->getClientOriginalName();
                $img = new Picture();
                $img->file_name = 'advertimages/'.date('YmdHis',time()).'-'.$name;
                $img->owner_id = auth()->id();
                $img->advert_id = $id;
                $img->save();
                $imgcont = $image->get();
                Storage::disk('public')->put($img['file_name'], $imgcont);
                }
        } elseif (isset($val['base64key']) && isset($val['imagename'])) {
            $pictr = $val['base64key'];
            $type = explode(',', $pictr);
            $data = base64_decode($type[1]);
            $name = $val['imagename'];
            $img = new Picture();
            $img->file_name = 'advertimages/'.date('YmdHis',time()).'-'.$name;
            $img->owner_id = auth()->id();
            $img->advert_id = $id;
            $img->save();
            Storage::disk('public')->put($img['file_name'], $data);
        }
        return;
    }
    public function convertBase64($adv)
    {
        $base64Img=[];
        foreach ($adv->pictures as $picture) {
            $image = Storage::get('public/'.$picture->file_name);
            $imageData = base64_encode($image);
            $src = 'data: '.mime_content_type(getcwd().'/../storage/app/public/'.$picture->file_name).';base64,'.$imageData;
            array_push($base64Img, $src);
        }
        return $base64Img;
    }


    public function updateImage($val, $adv) {
        if (isset($val['images'])) {
            // 1 line new method
            foreach ($adv->pictures as $picture) {
                Storage::disk('public')->delete($picture['file_name']);
                $picture->delete();
            }
            $this->storeImage($val, $adv->id);
        } elseif (isset($val['base64key'])) {
            // 1 line new method
            foreach ($adv->pictures as $picture) {
                Storage::disk('public')->delete($picture['file_name']);
                $picture->delete();
            }
            $this->storeImage($val, $adv->id);
        }
        return;
    }

    public function deleteImage($adv) {
        foreach ($adv->pictures as $picture) {
            Storage::disk('public')->delete($picture['file_name']);
            $picture->delete();
        }
        return;
    }
    public function startbidCheck($adv) {
        {
            if (!is_null($adv->startbid)) {
                session()->flash('startbid', $adv->startbid);
                session()->flash('advert_id', $adv->id);
            } else {
                session()->forget('startbid');
                session()->forget('advert_id');
            };
        }
        return;
    }
}