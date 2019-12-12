<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth')->only(['home']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }
    
    public function index(Request $request)
    {
        // probeer consistent te zijn met inspringen van code blokken
        if ($request->ajax()) {
                if (empty($request->get('categories'))) {
                    $adverts = Advert::paginate(8);
                    return view('partials.advertindex', ['adverts' => $adverts]);  
            } else
                $numbers = $request->get('categories');
                $category_ids = preg_split("/\,/", $numbers);
                $adverts = Advert::whereHas('categories', function ($query) use ($category_ids) {
                    $query->whereIn('categories.id', $category_ids);
                })->paginate(8);
                return view('partials.advertindex', ['adverts' => $adverts]);
        }
        $adverts = Advert::paginate(8);
        $categories = Category::all();
        return view('index', compact('adverts', 'categories'));
    }
}
