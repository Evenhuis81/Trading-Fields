<?php

namespace App\Http\Controllers;

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
        $request['bids'] ? $advert = Advert::create($validated + ['owner_id' => auth()->id()]) : $advert = Advert::create($validated + ['owner_id' => auth()->id(), 'startbid' => null]);
        // Create Picture(s)
        $this->storeImage($request, $advert);
        // Attach Category
        $advert->categories()->sync($validated['category']);

        return redirect('/adverts/create')->with('success', 'Successfully Create New Advert!')
                                            ->with('advertid', $advert->id);
    }
    public function show(Advert $advert)
    {
        // dd($advert = Advert::findOrFail(88));
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
        dd($validated);
        // dd(collect($validated)->except(['category'])->toArray());
        // dd($request['bids']);
        //unset($validated["category"]);
        //dd(collect($validated)->except(['category']));
        // Update Advert
        $request['bids'] ? $advert->update(collect($validated)->except(['category'])->toArray()) : $advert->update(collect($validated)->except(['category'])->toArray() + ['startbid' => null]);
        $advert->categories()->sync([$validated['category']]);
        // if ($validated['title'] == $advert->title) {
        //     if ($validated['description'] == $advert->description) {
        //         if ($validated['price'] == $advert->price) {
        //                 // dd($advert->categories()->first()->id);
        //                 // dd($validated['category']);
        //                 if ($validated['category'] == $advert->categories()->first()->id) {
        //                     dd('hi');
        //                 }
        //         }
        //     }
        // }

        // $data = $request->session()->all();
        // dd($data);
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string|min:3|max:50',
        //     'description' => 'required|string|min:3|max:500',
        //     'price' => 'required|integer|min:0|max:10000',
        //     'category' => 'required|integer',
        //     'startbid' => ['nullable', 'integer', 'min:0', 'max:10000'],
        //     'images' => 'required|array|min:1',
        //     'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        // if ($validator->fails()) {
        //     $failreturn = redirect('/adverts/'.$advert->id.'/edit')
        //     ->withErrors($validator)
        //     ->withInput();
        //     if (is_null($request['bids'])) {
        //         return $failreturn->with('bidcheckoff', 'a');
        //     } else {
        //         return $failreturn->with('bidcheckon', 'a');
        //     }   
        // }
        // if ($request->hasFile('images')) {
        //     foreach ($advert->pictures as $picture) {
        //         $picture->delete();
        //     }
        // }
        return redirect('adverts/'.$advert->id.'/edit')->with('success', 'You have successfully edited your Advert!');
    }
    public function destroy(Advert $advert)
    {
        $this->authorize('update', $advert);
        $advert->delete();
    }
    public function storeImage($req, $adv)
    {
        if (isset($req['images'])) {
            foreach ($req->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $img = new Picture();
                $img->file_name = 'advertimages/'.date('YmdHis',time()).'-'.$name;
                $img->owner_id = auth()->id();
                $img->advert_id = $adv->id;
                $img->save();
                $imgcont = $image->get();
                Storage::disk('public')->put($img['file_name'], $imgcont);
                }
        } else {
            $pictr = $req['base64key'];
            $type = explode(';', $pictr);
            $data = base64_decode($type[1]);
            $name = $req['imagename'];
            $img = new Picture();
            $img->file_name = 'advertimages/'.date('YmdHis',time()).'-'.$name;
            $img->owner_id = auth()->id();
            $img->advert_id = $adv->id;
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
