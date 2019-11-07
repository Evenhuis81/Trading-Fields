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

        // $this->authorize('update', $advert);

        // Validated Through Request
        // dd($request);
        $validated = $request->validated();
        // Create Advert
        $advert = Advert::create($validated + ['owner_id' => auth()->id()]);
        // Create Picture(s)
        $this->storeImage($request, $advert);
        // Attach Category
        $advert->categories()->sync($validated['category']);

        return redirect('/adverts/create')->with('success', 'Successfully Create New Advert!')
                                            ->with('advertid', $advert->id);
    }
    public function storeImage($req, $adv)
    {
        if (isset($req['images'])) {
            foreach ($req->file('images') as $image) {
                // dd($image);
                $name = $image->getClientOriginalName();
                $img = new Picture();
                $img->file_name = '/advertimages/'.date('YmdHis',time()).'-'.$name;
                $img->owner_id = auth()->id();
                $img->advert_id = $adv->id;
                $img->save();
                $image->move(public_path() . '/advertimages/', $img['file_name']);
                }
        } else {
            // dd(public_path());
            $pictr = $req['base64key'];
            $ini = substr($pictr, 12);
            $type = explode(';', $ini);
            $data = base64_decode($type[1]);
            $name = "test.".$type[0];
            $img = new Picture();
            $img->file_name = 'advertimages/'.date('YmdHis',time()).'-'.$name;
            $img->owner_id = auth()->id();
            $img->advert_id = $adv->id;
            $img->save();
            //$data->move(public_path() . '/advertimages/', $img['file_name']);

            Storage::put($img['file_name'], $data);




            // preg_match("/^data:image\/(.*);base64/i",$pictr, $match);
            // $extension = $match;
            // echo $type[0]; // result png
            // $pictr1 = substr($pictr, 5, strpos($pictr, ';')-5);
            // dd($pictr);
            // dd($req['base64key']);
            // $offset = strpos($req['base64key'], ',');
            // $data = base64_decode(substr($req['base64key'], $offset));
            // list($type, $data) = explode(';', $req['base64key']); // exploding data for later checking and validating 
            // if (preg_match('/^data:image\/(\w+);base64,/', $req['base64key'], $type)) {
            //     $data = substr($data, strpos($data, ',') + 1);
            //     $type = strtolower($type[1]); // jpg, png, gif
            //     dd($type);
            // }

        }
    
        
        // $request->hasFile('images') {
        // foreach ($req->file('images') as $image) {
        //     $name = $image->getClientOriginalName();
        //     $img = new Picture();
        //     $img->filename = '/advertimages/'.date('YmdHis',time()).'-'.$name;
        //     $img->owner_id = auth()->id();
        //     $img->advert_id = $adv->id;
        //     $img->save();
        //     $image->move(public_path() . '/advertimages/', $img['filename']);
        //     }
            // return back();
    }
    public function show(Advert $advert)
    {
        // dd($advert = Advert::findOrFail(88));
    }
    public function edit(Advert $advert)
    {
        $this->authorize('update', $advert);
        // abort_if($advert->owner_id !== auth()->id(), 403);
        $categories = Category::all();
        $base64Img=[];
        foreach ($advert->pictures as $picture) {
            $image = public_path($picture->file_name);
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
        $this->authorize('update', $advert);
        // dd(str_random(10));
        // dd($newToken);
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
        $this->authorize('update', $advert);
        $advert->delete();
        // return back;
    }
}
