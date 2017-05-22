<?php

namespace App\Http\Controllers;

use App\Category;
use App\Location;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Mews\Purifier\Facades\Purifier;

class PostApiController extends Controller
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
        $posts = Post::orderBy('id', 'desc')->withCount('comments','likes')->paginate(2);
        foreach ($posts as $post){
            $post->comments_count;
            $post->likes_count;
            if(Auth::id() == $post->user_id){
                $post['can_edit'] = "true";
            }
            else{
                $post['can_edit'] = "false";

            }
            $post->category;
            $post->tags;
//            $post['user_name'] = $post['user']['name'];
            $post['user']['image'] = '139.59.79.241/images/'.$post['user']['image'];
//            $post['user_address'] = $post['user']['address'];
            $post['location'] = $post->location;
            $post['is_liked'] = $post->isLiked;
            $post['image'] = '139.59.79.241/images/'.$post['image'];
        }
//        foreach ($posts as $post) {
//            $this->transform($post);
//        }
        return Response::json([
        'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
//    public function create()
//    {
//        $categories = Category::all();
//        $tags = Tag::all();
//
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
//        $this->validate($request, array(
//            'title'         => 'required|max:255',
//            'slug'          => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
//            'category_id'   => 'required|integer',
//            'body'          => 'required'
//        ));

        // store in the database
        $post = new Post;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->user_id = $request->user()->id;
        $post->body = Purifier::clean($request->body);


        if ($request->hasFile('featured_img')) {
            $image = $request->file('featured_img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            $post->image = $filename;
        }
        $post->save();
        $location = new Location;
        $location->area = $request->area;
        $location->lat = $request->lat;
        $location->lng = $request->lng;
        $location->post_id = $post->id;
        $location->save();

        $post->tags()->sync($request->tags, false);
        return Response::json([
            'message'=>'post created successfully'
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
        $post = Post::find($id);
        $post->location;
        if(!$post){
            return Response::json([
                'error' => [
                    'message' => 'Post does not exist'
                ]
            ], 404);
        }

        return Response::json([
            'data' => $this->transform($post)
        ], 200);
    }


    private function transform($post){
        return [
            'post_id' => $post['id'],
            'posted_by' => $post['user']['name'],
            'user_id' => $post['user']['id'],
            'user_image'=> '139.59.79.241/images/'.$post['user']['image'],
            'user_address'=> $post['user']['address'],
            'body' => $post['body'],
            'title' => $post['title'],
            'slug' => $post['slug'],
            'image_url' => '139.59.79.241/images/'.$post['image'],
            'tags'=> $post['tags'],
            'category'=> $post['category'],
            'likes' => $post['likes']->count(),
            'comments' => $post['comments']->count(),
            'location'=> $post->location,
            'created_at' => $post['created_at'],
            'updated_at' => $post['updated_at']

        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
//    public function edit($id)
//    {
//        // find the post in the database and save as a var
//        $post = Post::find($id);
//        $categories = Category::all();
//        $cats = array();
//        foreach ($categories as $category) {
//            $cats[$category->id] = $category->name;
//        }
//
//        $tags = Tag::all();
//        $tags2 = array();
//        foreach ($tags as $tag) {
//            $tags2[$tag->id] = $tag->name;
//        }
//        // return the view and pass in the var we previously created
//        return view('posts.edit')->with('post',$post)->with('categories',$cats)->with('tags',$tags2);
//
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the data
//            $this->validate($request, array(
//                'title' => 'required|max:255',
//                'slug'  => "required|alpha_dash|min:5|max:255|unique:posts,slug,$id",
//                'category_id' => 'required|integer',
//                'body'  => 'required',
//                'featured_image' => 'image'
//            ));


        // Save the data to the database
        $post = Post::find($id);
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);
            $oldFileName = $post->image;
            $post->image = $filename;
            Storage::delete($oldFileName);
        }
        if($request->tags) {
            $post->tags()->detach();
            $post->tags()->sync($request->tags, false);
        }
        $post->save();
        $location = $post->location;
        $location->area = $request->area;
        $location->lat = $request->lat;
        $location->lng = $request->lng;
        $location->post_id = $post->id;
        $location->save();


        return Response::json([
            'message'=>'post updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        Storage::delete($post->image);
        $location = $post->location;
        $comments = $post->comments;
        $location->delete();
        foreach($comments as $comment) {
            $comment->delete();
        }
        $post->delete();


        return Response::json([
            'message'=>'post successfully deleted'
        ]);
    }
}
