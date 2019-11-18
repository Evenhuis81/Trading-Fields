<?php

namespace App\Http\Controllers;

use App\Advert;
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
    public function addbid(Request $request)
    {
        $this->authorize('auth');
        
    }
}
