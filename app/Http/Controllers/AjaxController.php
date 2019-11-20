<?php

namespace App\Http\Controllers;

use App\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                $highestbid = 1;
        if (!is_null(session()->get('bidcount'))) {
            $highestbid = (Bid::latest()->first()->value +1);
        };
        $validator = Validator::make($request->all(), [
        'inputbid' => "required|integer|min:$highestbid|max:10000",
        ]);
        if ($validator->passes()) {
            return view('partials.bidsshow');
			return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
        // if ($validator->fails())
        // {
        //     return response()->json([
        //         'success' => 'false',
        //         'errors'  => $validator->errors()->all(),
        //     ], 400);
        // }
        // else
        // {
        //     try
        //     {
        //         $this->insertAddress($addressData);
        //         return response()->json(['success' => true], 200);
        //     }
        //     catch(Exception $e)
        //     {
        //         return response()->json([
        //             'success' => 'false',
        //             'errors'  => $e->getMessage(),
        //         ], 400);
        //     }

        // }
        // Bid::create([
        //     'advert_id' => session()->get('advert_id'),
        //     'owner_id' => auth()->id(),
        // ] + $value);
        // $var = $request->session()->get('_previous');
        // $var = explode("/", url()->previous());
        // $bids = Bid::all()->orderBy('value', 'desc');
        // return view('partials.bidsshow', compact('bids'));
    }
}
