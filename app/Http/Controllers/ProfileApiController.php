<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileApiController extends Controller
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
        $user = User::find(Auth::id());
        $user['image'] = "139.59.79.241/images/".$user['image'];
        $posts = $user->posts;
        foreach ($posts as $post){
            $post['comments_count'] = $post->comments()->count();
            $post['likes_count'] = $post->likes()->count();
            $post['location'] = $post->location;
            $post['is_liked'] = $post->isLiked;
            $post->category;
            $post->tags;
            $post['image'] = '139.59.79.241/images/'.$post['image'];
            if(Auth::id() == $user->id){
                $post['can_edit'] = "true";
            }
            else{
                $post['can_edit'] = "false";

            }
        }
        if(Auth::id() == $user->id){
            $user['can_edit'] = "true";
        }
        else{
            $user['can_edit'] = "false";

        }
        return Response::json([
            'profile' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::find($id);
        $user['image'] = "139.59.79.241/images/".$user['image'];
        $posts = $user->posts;
        foreach ($posts as $post){
            $post['comments_count'] = $post->comments()->count();
            $post['likes_count'] = $post->likes()->count();
            $post['location'] = $post->location;
            $post['is_liked'] = $post->isLiked;
            $post->category;
            $post->tags;
            $post['image'] = '139.59.79.241/images/'.$post['image'];
            if(Auth::id() == $user->id){
                $post['can_edit'] = "true";
            }
            else{
                $post['can_edit'] = "false";

            }
        }
        if(Auth::id() == $user->id){
            $user['can_edit'] = "true";
        }
        else{
            $user['can_edit'] = "false";

        }
        return Response::json([
            'profile' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
//        $user = User::find($id);
//        return view('users.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    $user = User::find($id);

        if(Auth::id() == $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($image)->resize(800, 400)->save($location);
                $oldFileName = $user->image;
                $user->image = $filename;
                Storage::delete($oldFileName);
            }
            $user->save();

        }
        return Response::json([
            'message' => "Update Succesful"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $user = User::find($id);
        if(Auth::id() == $user->id) {
            $posts = $user->posts;
            foreach($posts as $post) {
                $post->tags()->detach();
                Storage::delete($post->image);
                posts()->delete();
            }
            $user->delete();

        }
        return Response::json([
            'message' => "User is deleted successfully"
        ]);    }
}
