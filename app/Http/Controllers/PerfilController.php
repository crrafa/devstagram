<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
       
       return view('perfil.index');
    }

    public function store(Request $request) {
        if ($request->password &&
        !auth()->attempt(['email'=>auth()->user()->email,'password'=>$request->password])) {
            return back()->with('mensaje','Password Incorrecta');
        }

        $request->request->add(['username'=>Str::slug($request->username)]);
        $this->validate($request,[
            'username'=>['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:twitter,editar-perfil'],
            'email'=> ['required','unique:users,email,'.auth()->user()->id,'email','max:60'],
            'new_password' => ['nullable','required_with:password','confirmed','min:6'],
        ]);


        if ($request->imagen) {
            $imagen= $request->file('imagen');
            $nombreImagen = Str::uuid().".".$imagen->extension();
            $imagenServidor= Image::make($imagen);
            $imagenServidor->fit(1000,1000,null);
            $imagenPath= public_path('perfiles').'/'.$nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        $usuario = User::find(auth()->user()->id);
        $usuario -> username = $request -> username;
        $usuario -> email = $request -> email;
        $usuario -> imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario -> password = $request -> new_password ?? auth()->user()->password;
        $usuario -> save();

        return redirect()->route('posts.index',$usuario->username);
    }
}
