<?php

namespace App\Http\Controllers;

use App\Pp4;
use App\Advert;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        // why does F5 on return view('index.searchresults') askes for send data again ==>>(cause it's return view through a post!!?? see comment below this one)<<==, test with named routes or return views through (another)controller
        // ultimately: how to avoid ask for send data again with some persistant on queryinput and categoryinput etc (flash msgs that's need to be kept for particular page) without transforming to get (like most sites do)
        // session->flash persists for 2 views if you don't redirect, either use session forget in searchresults and searchbar after you 'used' flash or make redirects
        // (this comes with the problem that you can't do compact, so on F5 data gone unless *too complicated?*...), for now I use session->forget
        // optional: search on title and description option like marktplaats.nl
        // for now just flash, but else: (see comment last request category)
        // Empty the session filters?
        // session->forget('categoryinput');

        // All zipcode results:
        // 1st -> just zipcode without distance; (=all);  >>done<<
        // 2nd -> just zipcode with distance;; <<done>>
        // 3rd -> just zipcode without distance with category;  <<done>>
        // 4th -> just zipcode with distance with category; <<done>>
        // 5th -> input + zipcode without distance;  <<done>>
        // 6th -> input + zipcode with distance; <<done>>
        // 7th -> input + zipcode without distance with category; <<done>>
        // 8th -> input + zipcode with distance with category; <<done>>

        if (request('zipcode')) {
            // true or false
            $zipcode = $this->zipcheck(request('zipcode'));
            if ($zipcode) {
                $zip = strtoupper(request('zipcode'));
                cookie()->queue('pc', $zip, 526000);
                session()->flash('queuedcookie', $zip);
                if (request('distance')) {
                    session()->flash('distancefilter', "distance < ".request('distance')." km");
                    session()->flash('distanceinput', request('distance'));
                    if (request('category')) {
                        session()->flash('categoryfilter', Category::where('id', request('category'))->value('name'));
                        session()->flash('categoryinput', request('category'));
                        if (request('searchquery')) {
                            $query = request('searchquery');
                            session()->flash('queryinput', $query);

                            // 8th
                            $points = $this->points(substr($zip, 0, 4), request('distance'));
                            $zippiesarr=[];
                            foreach ($points as $point) {
                                array_push($zippiesarr, $point->postcode);
                            }
                            $adverts = Advert::whereIn('zipcode', $zippiesarr)
                                            ->whereHas('categories', function($q) {
                                            $q->wherein('categories.id', [request('category')]);
                                        })->where('title', 'LIKE', "%{$query}%")
                                        ->get();
                            if ($adverts->count()==0) {return redirect('/')->with('noresultmsg', 'search gave no results');}
    
                            return view('index.searchresults', compact('adverts', 'points'));
                        } else {
                            // 4th
                        $points = $this->points(substr($zip, 0, 4), request('distance'));
                        $zippiesarr=[];
                        foreach ($points as $point) {
                            array_push($zippiesarr, $point->postcode);
                        }
                        $adverts = Advert::whereIn('zipcode', $zippiesarr)
                                        ->whereHas('categories', function($q) {
                                        $q->wherein('categories.id', [request('category')]);
                                    })->get();
                        if ($adverts->count()==0) {return redirect('/')->with('noresultmsg', 'search gave no results');}

                        return view('index.searchresults', compact('adverts', 'points'));
                        }
                    }
                    if (request('searchquery')) {
                        $query = request('searchquery');
                        session()->flash('queryinput', $query);
                        // 6th

                        $points = $this->points(substr($zip, 0, 4), request('distance'));
                        $zippiesarr=[];
                        foreach ($points as $point) {
                            array_push($zippiesarr, $point->postcode);
                        }
                        $adverts = Advert::whereIn('zipcode', $zippiesarr)
                            ->where('title', 'LIKE', "%{$query}%")
                            ->get();
                        if ($adverts->count()==0) {return redirect('/')->with('noresultmsg', 'search gave no results');}

                        return view('index.searchresults', compact('adverts', 'points'));
                    } else {
                        // 2nd
                        $points = $this->points(substr($zip, 0, 4), request('distance'));
                        $zippiesarr=[];
                        foreach ($points as $point) {
                            array_push($zippiesarr, $point->postcode);
                        }
                        $adverts = Advert::whereIn('zipcode', $zippiesarr)->get();
                        if ($adverts->count()==0) {return redirect('/')->with('noresultmsg', 'search gave no results');}

                        return view('index.searchresults', compact('adverts', 'points'));
                    }
                }
                if (request('category')) {
                    session()->flash('categoryfilter', Category::where('id', request('category'))->value('name'));
                    session()->flash('categoryinput', request('category'));
                    if (request('searchquery')) {
                        // 7th
                        session()->flash('queryinput', request('searchquery'));
                        $query = request('searchquery');
                        $adverts = Advert::where('title', 'LIKE', "%{$query}%")->whereHas('categories', function($q) {
                            $q->wherein('categories.id', [request('category')]);
                        })->get();
                        if (!$adverts->count()) {
                            return redirect('/')->with('noresultmsg', 'search gave no results');
                        } else {
                            return view('index.searchresults', compact('adverts'));
                        }
                    } else {
                        // 3rd
                        $adverts = Advert::whereHas('categories', function($q) {
                            $q->wherein('categories.id', [request('category')]);
                        })->get();
                        return view('index.searchresults', compact('adverts'));
                    }
                }
                if (request('searchquery')) {
                    session()->flash('queryinput', request('searchquery'));
                    // 5th
                    $query = request('searchquery');
                    $adverts = Advert::where('title', 'LIKE', "%{$query}%")->get();
                    if ($adverts->count()==0) {return redirect('/')->with('noresultmsg', 'search gave no results');}
                    return view('index.searchresults', compact('adverts'));
                } else {
                    // 1st
                    return redirect('/');
                }
            } else {
                session()->flash('invalidzipmsg', 'not a valid zipcode');
                session()->flash('invalidzip', request('zipcode'));
                return redirect()->back();
            }
        }

        cookie()->queue(cookie()->forget('pc'));
        session()->forget('queuedcookie');
        session()->flash('nozipflash', 'a');

        if (request('category')) {

            // for now just flash, but I want to keep it permanent ONLY when user refreshes searchresultpage (that's why 404 on get search and empty session filter on each new search see comment on both searchbar and index.results page (categoryfilter, categoryinput))
            session()->flash('categoryfilter', Category::where('id', request('category'))->value('name'));
            session()->flash('categoryinput', request('category'));

            if (request('searchquery')) {
                // same thing here, for now just flash, but I want it permanent till user goes to other page
                session()->flash('queryinput', request('searchquery'));
                $query = request('searchquery');
                $adverts = Advert::where('title', 'LIKE', "%{$query}%")->whereHas('categories', function($q) {
                    $q->wherein('categories.id', [request('category')]);
                })->get();
                if (!$adverts->count()) {
                    return redirect('/')->with('noresultmsg', 'search gave no results');
                } else {
                    return view('index.searchresults', compact('adverts'));
                }
            } else {
                $adverts = Advert::whereHas('categories', function($q) {
                    $q->wherein('categories.id', [request('category')]);
                })->get();
                return view('index.searchresults', compact('adverts'));
            }
        }

        if (request('searchquery')) {
            session()->flash('queryinput', request('searchquery'));
            $query = request('searchquery');
            $adverts = Advert::where('title', 'LIKE', "%{$query}%")->get();
            if ($adverts->count()==0) {return redirect('/')->with('noresultmsg', 'search gave no results');}
            return view('index.searchresults', compact('adverts'));
        } else {
            return redirect('/');
        }


        // // Empty search redirects back to homepage (distance only works with valid zipcode) (=all, can remove if and make it last fake-else)
        // if (!request('query') && !request('category') && !request('zipcode')) {
        //     $cookie = cookie()->forget('pc');
        //     return redirect('/')->withCookie($cookie);
        // }
        
        // // No input search with category, without zipcode, gives category result only
        // if (!request('query') && request('category') && !request('zipcode')) {
        //     $adverts = Advert::whereHas('categories', function($q) {
        //         $q->wherein('categories.id', [request('category')]);
        //     })->get();
        //     session()->flash('categoryfilter', Category::where('id', request('category'))->value('name'));
        //     session()->flash('categoryinput', request('category'));
        //     return view('index.searchresults', compact('adverts'));
        // }

        // // Input search without category, without zipcode, gives advert->title result
        // if (request('query') && !request('category') && !request('zipcode')) {
        //     $query = request('query');
        //     $adverts = Advert::where('title', 'LIKE', "%{$query}%")->get();
        //     if ($adverts->count()==0) {return redirect('/')->with('noresultmsg', 'search gave no results');}
        //     return view('index.searchresults', compact('adverts'));
        // }

        // // Input search with category, without zipcode (change redirect into no searchresult page)
        // if (request('query') && request('category') && !request('zipcode')) {
        //     $query = request('query');
        //     $adverts = Advert::where('title', 'LIKE', "%{$query}%")->whereHas('categories', function($q) {
        //         $q->wherein('categories.id', [request('category')]);
        //     })->get();
        //     if (!$adverts->count()) {
        //         return redirect('/')->with('noresultmsg', 'search gave no results');
        //     } else {
        //         // can replace else with last fake else(=all)
        //         return view('index.searchresults', compact('adverts'));
        //     }
        // }
        // // No input search without category, with zipcode input, with all distances (=all)
        // if (!request('query') && !request('category') && request('zipcode') && !request('distance')) {
        //     $zipcode = $this->zipcheck(request('zipcode'));
        //     if ($zipcode) {
        //         $zip = strtoupper(request('zipcode'));
        //         cookie()->queue('pc', $zip, 526000);
        //         // return redirect('/')->withCookie('pc', $zip, 526000);
        //         return redirect('/');
        //     } else {
        //         session()->flash('invalidzipmsg', 'not a valid zipcode');
        //         session()->flash('invalidzip', request('zipcode'));
        //         return redirect('/');
        //     }
        // }

        // fake else (see =all comment)
        // return ('index.searchresults', compact('adverts'));
    }

    private function zipcheck($zipcode)
    {
        
        // semi-rule: Ln < 80? Col => Shorthand Syntax, in this case not possible anyway cause of return. (or is there a way?)
        // 2ndly: bad practice jamming all method in a method or make more variables? and in this case/these cases?
        if (strlen($zipcode) !==6) {  
            return false;
        };
        if (!preg_match("/^[a-zA-Z]+$/", substr($zipcode, 4, 6))) {return false;}
        if (!preg_match("/^[0-9]+$/", substr($zipcode, 0, 4))) {return false;}
        return Pp4::where('postcode', substr($zipcode, 0, 4))->exists();
    }

    public function points($zip, $radius)
    {
        $lat = Pp4::where('postcode', $zip)->value('latitude');
        $lon = Pp4::where('postcode', $zip)->value('longitude');
        return Pp4::selectRaw("id, postcode, latitude, longitude,
                ( 6371 * acos( cos( radians(?) ) *
                cos( radians( latitude ) )
                * cos( radians( longitude ) - radians(?)
                ) + sin( radians(?) ) *
                sin( radians( latitude ) ) )
                ) AS distance", [$lat, $lon, $lat])
            ->having("distance", "<", $radius)
            ->orderBy("distance")
            ->get();
            // $points = Pp4::selectRaw("pp4s.id, pp4s.postcode as postcode, pp4s.latitude as latitude, pp4s.longitude as longitude, adverts.title as title,
            //         ( 6371 * acos( cos( radians(?) ) *
            //         cos( radians( latitude ) )
            //         * cos( radians( longitude ) - radians(?)
            //         ) + sin( radians(?) ) *
            //         sin( radians( latitude ) ) )
            //         ) AS distance", [$lat, $lon, $lat])
            //     // ->where('active', '1')
            //     ->leftJoin('adverts', 'adverts.zipcode', '=', 'pp4s.postcode')
            //     ->having("distance", "<", $radius)
            //     ->orderBy("distance")
            //     ->get();
    }
}
