<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Request $request){

        $validation = $this->validate($request,[
            'image_id' => ['integer','required'],
            'content' => ['string','required']
        ],[
            'content.required' => $request->input('image_id'),
            'content.string' => $request->input('image_id')
        ]);

        $content = $request->input('content');
        $image_id = $request->input('image_id');
        $user_id = Auth::user()->id;

        $comment = new Comment();

        $comment->content = $content;
        $comment->image_id = $image_id;
        $comment->user_id = $user_id;

        $comment->save();

        return redirect()->route('home');

    }
}
