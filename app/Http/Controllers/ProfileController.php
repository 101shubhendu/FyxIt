<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $profile = User::find(Auth::id());
        $posts = $profile->posts;
        return view('users.profile')->with('profile',$profile)->with('posts',$posts);

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
        $profile = User::find($id);
        $posts = $profile->posts;
        return view('users.profile')->with('profile',$profile)->with('posts',$posts);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit')->with('user',$user);
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

            Session::flash('success', 'Successfully saved changes!');
        }
        return redirect()->route('user.profile', $user);
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

            Session::flash('success', 'User is deleted successfully');
        }
        return redirect()->route('/logout');
    }
}
