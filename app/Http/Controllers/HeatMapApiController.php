<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class HeatMapApiController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
      $locations = Location::all();
//        $products = Location::where('area', 'LIKE', '%'.'Uttar Pradesh'.'%')->get();
        return $locations;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request, array('name' => 'required|max:255'));
        $tag = new Tag;
        $tag->name = $request->tag;
        $tag->save();
        return Response::json([
            'message' => 'Tag created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        if(!$tag){
            return Response::json([
                'error' => [
                    'message' => 'Tag does not exist'
                ]
            ], 404);
        }

        return Response::json([
            'data' => $tag
        ], 200);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   if(! $request->tag ){
        return Response::json([
            'error' => [
                'message' => 'Please Provide Tag '
            ]
        ], 422);
    }
        $tag = Tag::find($id);
        if(! $tag){
            return Response::json([
                'error' => [
                    'message' => 'Tag does not exist'
                ]
            ], 404);
        }
//        $this->validate($request, ['name' => 'required|max:255']);


        $tag->name = $request->tag;
        $tag->save();
        return Response::json([
            'message' => 'Tag Updated Succesfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if(!$tag){
            return Response::json([
                'error' => [
                    'message' => 'Tag does not exist'
                ]
            ], 404);
        }
        $tag->posts()->detach();

        $tag->delete();

        return Response::json([
            'message' => 'Tag removed Successfully'
        ]);
    }
}
