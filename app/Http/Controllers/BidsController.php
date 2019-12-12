<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BidsController extends Controller
{
    // probeer controller methods te beperken tot CRUD-functies voor consistentie. Dus: store() i.p.v. inputbid,
    // delete() i.p.v. deletebid. Noem deze controller BidController, omdat deze controller alleen bid acties uitvoert.
    // Dat het om het afhandelen van AJAX requests gaat kun je aan de returned responses zien.
    public function store(Request $request)
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

    public function destroy(Request $request)
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
