<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Like;

class ImageController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function upload(){
        return view('images.upload');
    }

    public function save(Request $request){

        $validate = $this->validate($request,[
            'description' => ['required'],
            'image_path' => ['required','image']
        ]);

        $image_path = $request->file('image_path');
        $description = $request->input('description');

        $user = Auth::user();
        $image = new Image();
        $image->description = $description;
        
        if($image_path){
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name,File::get($image_path));
            $image->user_id = $user->id;
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')->with('message','Foto subida correctamente');

    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file,200);
    }

    public function delete($id){
        $user = Auth::user();
        $image = Image::find($id);

        $comments = Comment::where('image_id',$id)->delete();
        $likes = Like::where('image_id',$id)->delete();

        if($user && $image && $image->user->id == $user->id){

            Storage::disk('images')->delete($image->image_path);

            $image->delete();

        }

        return redirect()->route('home')->with('message','Imagen borrada');

    }

    public function update(Request $request){

        $validation = $this->validate($request,[
            'description' => ['required'],
            'image_path' => ['image'],
            'image_id' => ['required']
        ]);

        $image_id = $request->input('image_id');
        $description = $request->input('description');
        $image_path = $request->file('image_path');

        $image = Image::find($image_id);

        $image->description = $description;

        if($image_path){
            Storage::disk('images')->delete($image->image_path);

            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name,File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->update();

        return redirect()->route('user.profile',['id' => Auth::user()->id])->with('message','Imagen actualizada correctamente');

    }

}
