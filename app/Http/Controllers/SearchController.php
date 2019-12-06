<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Category;
// use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search() {
        // empty session filters
        session()->forget('categoryfilter');

        // Empty search redirects back to homepage (distance only works with valid zipcode input)  (=all aka can remove if and make it last else (fake))
        if (!request('query') && !request('category') && !request('zipcode')) {return redirect('/');}
        
        // Empty search with category input without zipcode gives category result
        if (!request('query') && request('category') && !request('zipcode')) {
            $adverts = Advert::whereHas('categories', function($q) {
                $q->wherein('categories.id', [request('category')]);
            })->get();
            session()->put('categoryfilter', Category::where('id', request('category'))->value('name'));
            session()->flash('categoryinput', request('category'));
            return view('index.searchresults', compact('adverts'));
        }

        // Query search without category & without zipcode input
        if (request('query') && !request('category') && !request('zipcode')) {
            $query = request('query');
            $adverts = Advert::where('title', 'LIKE', "%{$query}%")->get();
            if ($adverts->count()==0) {return redirect('/')->with('nosearch', 'Search gave 0 results');}
            return view('index.searchresults', compact('adverts'));
        }

        // Query search with category & without zipcode input (change redirect into no searchresult page)
        if (request('query') && request('category') && !request('zipcode')) {
            $query = request('query');
            $adverts = Advert::where('title', 'LIKE', "%{$query}%")->whereHas('categories', function($q) {
                $q->wherein('categories.id', [request('category')]);
            })->get();
            if ($adverts->count()==0) {return redirect('/')->with('nosearch', 'No results found');}
            return view('index.searchresults', compact('adverts'));
        }
        dd('last');
        // No Query search without category & with zipcode input with all distances (=all)
        // if (!request('query') && !request('category') && request('zipcode') && !request('distance')) {
        //     $zipcode = $this->zipcheck()
        //     return redirect('/');
        // }

        // return view('index.searchresults', compact('adverts'));
    }
}
