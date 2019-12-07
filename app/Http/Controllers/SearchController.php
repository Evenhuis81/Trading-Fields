<?php

namespace App\Http\Controllers;

use App\Pp4;
use App\Advert;
use App\Category;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Empty the session filters
        // session()->forget('categoryfilter');

        // Empty search redirects back to homepage (distance only works with valid zipcode) (=all, can remove if and make it last fake-else)
        if (!request('query') && !request('category') && !request('zipcode')) {return redirect('/');}
        
        // No input search with category, without zipcode, gives category result only
        if (!request('query') && request('category') && !request('zipcode')) {
            $adverts = Advert::whereHas('categories', function($q) {
                $q->wherein('categories.id', [request('category')]);
            })->get();
            session()->flash('categoryfilter', Category::where('id', request('category'))->value('name'));
            session()->flash('categoryinput', request('category'));
            return view('index.searchresults', compact('adverts'));
        }

        // Input search without category, without zipcode, gives advert->title result
        if (request('query') && !request('category') && !request('zipcode')) {
            $query = request('query');
            $adverts = Advert::where('title', 'LIKE', "%{$query}%")->get();
            if ($adverts->count()==0) {return redirect('/')->with('noresultmsg', 'Search gave no results');}
            return view('index.searchresults', compact('adverts'));
        }

        // Input search with category, without zipcode (change redirect into no searchresult page)
        if (request('query') && request('category') && !request('zipcode')) {
            $query = request('query');
            $adverts = Advert::where('title', 'LIKE', "%{$query}%")->whereHas('categories', function($q) {
                $q->wherein('categories.id', [request('category')]);
            })->get();
            if (!$adverts->count()) {
                return redirect('/')->with('noresultmsg', 'Search gave no results');
            } else {
                // can replace else with last fake else(=all)
                return view('index.searchresults', compact('adverts'));
            }
        }
        // No input search without category, with zipcode input, with all distances (=all)
        if (!request('query') && !request('category') && request('zipcode') && !request('distance')) {
            $zipcode = $this->zipcheck(request('zipcode'));
            if ($zipcode) {
                $zip = strtoupper(request('zipcode'));
                session()->put('zip', $zip);
                return redirect('/');
            } else {
                session()->flash('invalidzipmsg', 'That is not a valid zipcode');
                session()->flash('invalidzip', request('zipcode'));
                return redirect('/');
            }
        }

        // fake else (see =all comment)
        // return ('index.searchresults', compact('adverts'));
    }

    private function zipcheck($zipcode)
    {
        // semi-rule: Ln < 80? Col => Shorthand Syntax, in this case not possible anyway cause of return. (or is there a way?)
        // 2ndly: bad practice jamming all method in a method or make more variables? and in this case/these cases?
        if (!strlen($zipcode)==6) {return false;}
        if (!preg_match("/^[a-zA-Z]+$/", substr($zipcode, 4, 6))) {return false;}
        if (!preg_match("/^[0-9]+$/", substr($zipcode, 0, 4))) {return false;}
        return Pp4::where('postcode', substr($zipcode, 0, 4))->exists();
    }
}