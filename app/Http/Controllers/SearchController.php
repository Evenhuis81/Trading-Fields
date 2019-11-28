<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search() {
        if (!request('searchdata')) {return redirect('/');}
        
        
        request()->all();
        
        return view('index.searchresults');
    }
}
