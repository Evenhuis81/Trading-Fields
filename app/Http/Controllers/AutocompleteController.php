<?php

namespace App\Http\Controllers;

use App\Advert;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    function fetch(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = Advert::where('title', 'LIKE', "%{$query}%")->get();
            // $data = DB::table('categories')->where('name', 'LIKE', "%{$query}%")->get();
            if ($data->count()) {
                $output = '<ul class="dropdown-menu" style="display: block; position: absolute;">';
                foreach($data as $row) {
                    $output .= '<li><a class="dropdown-item border-bottom border-top">'.$row->title.'</a></li>';
                }
                $output .= '</ul>';
                return $output;
            }
        }
    }
}
