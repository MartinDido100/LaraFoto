<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($image_id,$cantLikes){
        
        $user = Auth::user();

        $isset_like = Like::where('user_id',$user->id)->where('image_id',$image_id)->count();

        if($isset_like == 0){
            $like = new like();
    
            $like->user_id = $user->id;
            $like->image_id = $image_id;
    
            $like->save();

            $cantLikes++;

            return response()->json([
                'like' => $like,
                'likeNumber' => $cantLikes
            ]);
        }else{
            return response()->json([
                'ok' => false
            ]);
        }

    }

    public function dislike($image_id,$cantLikes){

        $user = Auth::user();

        $like = Like::where('user_id',$user->id)->where('image_id',$image_id)->first();

        if($like){
            $like->delete();
            $cantLikes--;
            return response()->json([
                'like' => $like,
                'likeNumber' => $cantLikes
            ]);
        }else{
            return response()->json([
                'ok' => false
            ]);
        }
        

    }

}
