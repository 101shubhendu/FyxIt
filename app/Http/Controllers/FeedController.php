<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function getIndex() {
        $posts = Post::paginate(10);

        return view('feed.index')->with('posts',$posts);
    }

    public function getSingle($slug) {
        // fetch from the DB based on slug
        $post = Post::where('slug', '=', $slug)->first();

        // return the view and pass in the post object
        return view('feed.single')->with('post',$post);
    }
}
