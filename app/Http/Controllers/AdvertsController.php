<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Picture;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdvertStoreRequest;
use Illuminate\Support\Facades\Validator;

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

        $base64Img=[];
        foreach ($advert->pictures as $picture) {
            $imagee = Storage::url($picture->file_name);
            $image = Storage::get($picture->file_name);
            // Read image path, convert to base64 encoding
            $imageData = base64_encode($image);
            // Format the image SRC: data:{mime};base64,{data};
            // dd(getcwd());
            $src = 'data: '.mime_content_type('storage/'.$picture->file_name).';base64,'.$imageData;
            // $src = 'data: '.mime_content_type(getcwd() . $imagee).';base64,'.$imageData;
            array_push($base64Img, $src);
        }
        // dd($base64Img);
        // return view('adverts.edit', compact('advert', 'base64Img', 'categories'))->with('imagename');
        return view('adverts.edit', compact('advert', 'base64Img', 'categories'));
    }
    public function update(Request $request, Advert $advert)
    {
        $this->authorize('update', $advert);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|string|min:3|max:500',
            'price' => 'required|integer|min:0|max:10000',
            'category' => 'required|integer',
            // 'startbid' => ['nullable', 'integer', 'min:0', 'max:10000'],
            // 'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            $failreturn = redirect('/adverts/'.$advert->id.'/edit')
            ->withErrors($validator)
            ->withInput();
            if (is_null($request['bids'])) {
                return $failreturn->with('bidcheckoff', 'a');
            } else {
                return $failreturn->with('bidcheckon', 'a');
            }   
        }
        if ($request->hasFile('images')) {
            foreach ($advert->pictures as $picture) {
                $picture->delete();
            }
            // foreach ($request->file('images') as $image) {
            //     $name = $image->getClientOriginalName();
                
            //     $img = new Picture();
            //     $img->filename = date('YmdHis',time()).'-'.$name;
            //     $img->owner_id = auth()->id();
            //     $img->advert_id = $advert->id;
            //     $img->save();
            //     $image->move(public_path() . '/advertimages/', $img['filename']);
            //     }   
        }
        // if ($request['title']==$advert->title && $request['description']==$advert->description && $request['price']==$advert->price
        //     && $request['category']==$advert->category) {
        //         if ($advert->startbid==$request['bids'] or ($request['bids']=='on' && is_null(!$advert->startbid)) {
        //             dd('true');
        //         }
        //     }

        return redirect('/adverts/'.$advert->id.'/edit')->with('success', 'You have successfully edited your Advert!');
    }
    public function storeImage($req, $adv)
    {
        if (isset($req['images'])) {
            foreach ($req->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $img = new Picture();
                $img->file_name = 'public/advertimages/'.date('YmdHis',time()).'-'.$name;
                $img->owner_id = auth()->id();
                $img->advert_id = $adv->id;
                $img->save();
                $imgcont = $image->get();
                Storage::put($img['file_name'], $imgcont);
                }
        } else {
            $pictr = $req['base64key'];
            $type = explode(';', $pictr);
            $data = base64_decode($type[1]);
            $name = $req['imagename'];
            $img = new Picture();
            $img->file_name = 'public/advertimages/'.date('YmdHis',time()).'-'.$name;
            $img->owner_id = auth()->id();
            $img->advert_id = $adv->id;
            $img->save();
            Storage::put($img['file_name'], $data);
        }
    }
    public function destroy(Advert $advert)
    {
        $this->authorize('update', $advert);
        $advert->delete();
        // return back;
    }
}
