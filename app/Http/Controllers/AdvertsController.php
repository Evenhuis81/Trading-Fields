<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Picture;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\AdvertStoreRequest;
use Illuminate\Support\Facades\Validator;

class AdvertsController extends Controller
{  
    public function index()
    {
        $adverts = Advert::where('owner_id', (auth()->id()))->get();
        return view('adverts.index', compact('adverts'));
    }
    public function create()
    {
        // dd(session());
        $categories = Category::all();
        return view('adverts.create', compact('categories'));
    }
    public function store(AdvertStoreRequest $request)
    {
        $this->authorize('update', $advert);
        // Validated Through Request
        $validated = $request->validated();
        // Create Advert
        $advert = Advert::create($validated + ['owner_id' => auth()->id()]);
        // Create Picture(s)
        $img = $this->storeImage($request, $advert);
        // Attach Category
        $advert->categories()->sync($validated['category']);

        return redirect('/adverts/create')->with('success', 'Successfully Create New Advert!');
    }
    public function storeImage($req, $adv)
    {
        // $request->hasFile('images') {
        foreach ($req->file('images') as $image) {
            $name = $image->getClientOriginalName();
            $img = new Picture();
            $img->filename = '/advertimages/'.date('YmdHis',time()).'-'.$name;
            $img->owner_id = auth()->id();
            $img->advert_id = $adv->id;
            $img->save();
            $image->move(public_path() . '/advertimages/', $img['filename']);
            }
            return $img;
    }
    public function show(Advert $advert)
    {
        // return dd($advert = Advert::findOrFail($advert->id));
        // abort_if($advert->owner_id !== auth()->id(), 403);
    }
    public function edit(Advert $advert)
    {
        abort_if($advert->owner_id !== auth()->id(), 403);
        $categories = Category::all();
        $base64Img=[];
        foreach ($advert->pictures as $picture) {
            // dd(public_path($picture->filename));
            $image = public_path($picture->filename);
            // Read image path, convert to base64 encoding
            $imageData = base64_encode(file_get_contents($image));
            // Format the image SRC: data:{mime};base64,{data};
            $src = 'data: '.mime_content_type($image).';base64,'.$imageData;
            array_push($base64Img, $src);
            // Echo out a sample image
            // echo '<img src="'.$src.'">';
        }
        return view('adverts.edit', compact('advert', 'base64Img', 'categories'));
    }
    public function update(Request $request, Advert $advert)
    {
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
    public function destroy(Advert $advert)
    {
        $advert->delete();
    }
}
