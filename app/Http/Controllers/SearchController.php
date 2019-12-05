<?php

namespace App\Http\Controllers;

use App\Advert;
// use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search() {
        // dd(request());
        if (!request('query')) {return redirect('/');}
        $query = request('query');
        $adverts = Advert::where('title', 'LIKE', "%{$query}%")->get();

        return view('index.searchresults', compact('adverts'));
    }
}
