<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Advert;
use App\Picture;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\AdvertStoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AdvertUpdateRequest;

class AdvertsController extends Controller
{  
    public function __construct()
    {
        $this->middleware('adman')->except(['show']);
    }

    public function index()
    {
        $adverts = Advert::where('owner_id', (auth()->id()))->get();
        return view('adverts.index', compact('adverts'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('adverts.create', compact('categories'));
    }
    public function store(AdvertStoreRequest $request)
    {
        // Validated Through Request
        $validated = $request->validated();
                // Create Advert
        $validated['owner_id'] = auth()->id();
        if (!$request['bids']) { $validated['startbid'] = null; }
        $advert = Advert::create($validated);
        // Create Picture(s)
        $this->storeImage($validated, $advert->id);
        // Attach Category
        $advert->categories()->sync($validated['category']);

        return redirect('/adverts/create')->with('success', 'Successfully Create New Advert!')
                                            ->with('advertid', $advert->id);
    }
    public function show(Advert $advert)
    {
        if (!is_null($advert->startbid)) {
            session()->flash('startbid', $advert->startbid);
            session()->flash('advert_id', $advert->id);
        } else {
            session()->forget('startbid');
            session()->forget('advert_id');
        };
        return view('adverts.show', ['advert' => $advert]);
    }
    public function edit(Advert $advert)
    {
        $this->authorize('update', $advert);
        $categories = Category::all();
        $base64Img = $this->convertBase64($advert);
        return view('adverts.edit', compact('advert', 'base64Img', 'categories'));
    }
    public function update(AdvertUpdateRequest $request, Advert $advert)
    {
        // Validated Through Request
        $validated = $request->validated();
        // Check if new picture, if so: destroy old, create new
        if (isset($validated['images'])) {
            foreach ($advert->pictures as $picture) {
                Storage::disk('public')->delete($picture['file_name']);
                $picture->delete();
            }
            $this->storeImage($validated, $advert->id);
        } elseif (isset($validated['base64key'])) {
            foreach ($advert->pictures as $picture) {
                Storage::disk('public')->delete($picture['file_name']);
                $picture->delete();
            }
            $this->storeImage($validated, $advert->id);
        } // else {'something went wrong'}
        // Update Advert
        if (!$request['bids']) { $validated['startbid'] = null; }
        $advert->update($validated);
        $advert->categories()->sync([$validated['category']]);
        // if ($validated['title'] == $advert->title) {
        //     if ($validated['description'] == $advert->description) {
        //         if ($validated['price'] == $advert->price) {
        //                 // dd($advert->categories()->first()->id);
        //                 // dd($validated['category']);
        //                 if ($validated['category'] == $advert->categories()->first()->id) {
        return redirect('adverts/'.$advert->id.'/edit')->with('success', 'You have successfully edited your Advert!');
    }
    public function destroy(Advert $advert)
    {
        $this->authorize('update', $advert);
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
                // return with 'something went wrong msg,  ... or something ...' ;
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
    }
    public function convertBase64($adv)
    {
        $base64Img=[];
        foreach ($adv->pictures as $picture) {
            $image = Storage::get('public/'.$picture->file_name);
            // Read image path, convert to base64 encoding
            $imageData = base64_encode($image);
            // Format the image SRC: data:{mime};base64,{data};
            $src = 'data: '.mime_content_type(getcwd().'/../storage/app/public/'.$picture->file_name).';base64,'.$imageData;
            array_push($base64Img, $src);
        }
        return $base64Img;
    }
}
