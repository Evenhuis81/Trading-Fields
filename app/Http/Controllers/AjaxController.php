<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    public function inputbid(Request $request)
    {
        $startbid = session('startbid');
        $validator = Validator::make($request->all(), [
        'inputbid' => "required|integer|min:$startbid|max:10000",
        ]);
        if ($validator->passes()) {
            $advert = Advert::find(session('advert_id'));
            Bid::create([
                    'advert_id' => session()->get('advert_id'),
                    'owner_id' => auth()->id(),
                    'value' => $validator->validated()['inputbid']
                ]);
            session()->reflash();      
            return view('partials.bidsshow', compact('advert'));
        }
        session()->reflash();
        // return response()->json(['error'=>$validator->errors()->all()], 422);
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function deletebid(Request $request)
    {
        $advert = Advert::find(session('advert_id'));
        $bid = Bid::find($request->input('bid'));
        if ($bid->owner_id == auth()->id()) {
            $bid->delete();
            session()->reflash();
            return view('partials.bidsshow', compact('advert'));
        }
        session()->reflash();
        return response()->json(['error'=>$validator->errors()->all()]);
    }
}
