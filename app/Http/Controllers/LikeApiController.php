<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LikeApiController extends Controller
{   private $message;
    public function __construct() {
        $this->middleware('jwt.auth');
    }
    public function showComment($id){
    $likes = Comment::find($id)->likes;
    foreach ($likes as $user){
        $user->name;
    }

    return Response::json([
        'users' => $this->transformCollection($likes),
    ]);
    }
    public function showPost($id){
    $likes = Post::find($id)->likes;
        foreach ($likes as $user){
            $user->name;
        }
        return Response::json([
            'users' => $this->transformCollection($likes),
        ]);
    }
    private function transformCollection($likes){
        return array_map([$this, 'transform'], $likes->toArray());
    }
    private function transform($likes){
        return [
            'id' => $likes['id'],
            'name' => $likes['name'],

        ];
    }

    public function likeComment($id)
    {
        // here you can check if product exists or is valid or whatever

        $this->handleLike('App\Comment', $id);

        return Response::json([
            'message' => "Comment $this->message"
        ]);
    }

    public function likePost($id)
    {
        // here you can check if product exists or is valid or whatever

        $this->handleLike('App\Post', $id);

        return Response::json([
            'message' => "Post $this->message"
        ]);    }

    public function handleLike($type, $id)
    {
        $existing_like = Like::withTrashed()->whereLikeableType($type)->whereLikeableId($id)->whereUserId(Auth::id())->first();

        if (is_null($existing_like)) {
            Like::create([
                'user_id'       => Auth::id(),
                'likeable_id'   => $id,
                'likeable_type' => $type,
            ]);
            $this->message = "Liked";
        } else {
            if (is_null($existing_like->deleted_at)) {
                $existing_like->delete();
                $this->message = "Disliked";
            } else {
                $existing_like->restore();
                $this->message = "Liked";
            }
        }
    }
}
