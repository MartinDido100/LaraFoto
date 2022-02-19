<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function config(){
        return view('user.config');
    }

    public function update(Request $request){
        
        $user = Auth::user();

        $id = $user->id;

        $validate = $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255',"unique:users,nick,$id"],
            'email' => ['required', 'string', 'email', 'max:255',"unique:users,email,$id"],
            'image' => ['image']
        ]);

        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        //Actualizo
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //Subir la imagen
        $image_path = $request->file('image_path');
        if($image_path){
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('users')->put($image_path_name,File::get($image_path));

            $user->image = $image_path_name;
        }

        //Guardo en la BBDD
        $user->update();

        return redirect()->route('config')->with('message','Usuario actualizado correctamente')->withErrors(['pepe','El pepe papa']);
    }

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file,200);
    }

    public function profile($id){
        $user = User::find($id);
        return view('user.profile',[
            'user' => $user
        ]);
    }

    public function index($value = null){
        $users = User::where('nick','LIKE',"%$value%")->orderBy('id','desc')->paginate(5);

        return view('user.index',[
            'users' => $users
        ]);

    }

}
