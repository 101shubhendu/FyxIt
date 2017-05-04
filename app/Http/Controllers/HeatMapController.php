<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HeatMapController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }


    public function index(Request $request)
    { dd($request);
        $search_term = $request->get('search');
        if($search_term) {
            $locations = Location::where('area', 'LIKE', '%' . $search_term . '%')->get();
        }
        else{
            $locations = Location::all();
        }
        return view('map.heat')->with('locations',$locations);


    }
    public function posts(Request $request)
    { dd($request);
        $search_term = $request->get('search');
        if($search_term) {
            $locations = Location::where('area', 'LIKE', '%' . $search_term . '%')->get();
            foreach ($locations as $location){
                $post = $location->post;
                $post['image'] = '139.59.79.241/images/'.$post['image'];
            }
            return view('map.nearby')->with('locations',$locations);
        }
        else{
            return view('map.nearby')->with('locations',false);
        }


    }
}
