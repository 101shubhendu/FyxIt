<?php

namespace App\Http\Controllers;

use App\Location;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HeatMapApiController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }


    public function index(Request $request)
    {
        $search_term = $request->search;
        if($search_term) {
            $locations = Location::where('area', 'LIKE', '%' . $search_term . '%')->get();
        }
        else{
            $locations = Location::all();
        }
        return Response::json([
            'locations'=> $locations
        ]);

    }
    public function posts(Request $request)
    {
        $search_term = $request->search;

        $locations = Location::where('area', 'LIKE', '%' . $search_term . '%')->get();

        foreach ($locations as $location){
            $post = $location->post;
            $post['image'] = '139.59.79.241/images/'.$post['image'];
        }

        return Response::json([
            'near_by_posts'=> $locations
        ]);

    }

}
