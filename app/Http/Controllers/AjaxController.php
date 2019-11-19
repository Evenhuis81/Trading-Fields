<?php

namespace App\Http\Controllers;

use App\Bid;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // public function index(Request $request)
    // {
    //     $numbers = ($request->get('numbers'));
    //     if (empty($numbers)) {
    //         $adverts = Advert::paginate(8); 
    //     } else {
    //         $category_ids = preg_split("/\,/", $numbers);
    //         $adverts = Advert::whereHas('categories', function ($query) use ($category_ids) {
    //         $query->whereIn('categories.id', $category_ids);
    //         })->paginate(8);    
    //     }
    //     return view('partials.advertindex', compact('adverts'));
    // }
    public function store(Request $request)
    {
        $highestbid = 0;
        if (!is_null(session()->get('bidcount'))) {
            $highestbid = Bid::latest()->first()->value;
        };
        $value = request()->validate([
            'value' => "required|integer|min:$highestbid|max:10000",
        ]);
        // dd(auth()->id());
        Bid::create([
            'advert_id' => session()->get('advert_id'),
            'owner_id' => auth()->id(),
        ] + $value);
        // $var = $request->session()->get('_previous');
        // $var = explode("/", url()->previous());
        $bids = Bid::all();
        return view('partials.bidsshow', compact('bids'));
    }
}
