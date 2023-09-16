<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('layouts.usuario', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'=> 'required|string|max:255|unique:users,usuario,',
            'nombreusuario'=> 'required|string|max:255',
            'numerousuario'=> 'required|integer|max:8',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'password'=> 'required|string|min:8',
            'rolusuario'=>'required|string|max:255',
            'estadousuario'=>'required|string|max:255',
            'fotousuario'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return redirect()->route('usuario.index')->withErrors($validator)->withInput()->with('error', 'Error al crear el Usuario, revise e intente nuevamente');
        }

        $hashedPassword = bcrypt($request->input('password'));

        $users = User::create([
        'username'=>$request->input('username'),
        'nombreusuario'=>$request->input('nombreusuario'),
        'numerousuario'=>$request->input('numerousuario'),
        'email'=>$request->input('email'),
        'password'=>$request->input('password'),
        'rolusuario'=>$request->input('rolusuario'),
        'estadousuario'=>$request->input('estadousuario'),
        'password'=>$hashedPassword,
        ]);
        if($request->hasFile('fotousuario')){

        $uploadedFile=$request->file('fotousuario');
        $photoName=Str::slug($users->usuario) . '.' . $uploadedFile->getClientOriginalExtension();
        $photoPath=$uploadedFile->storeAs('public/usuarios', $photoName);
        $users->fotousuario=$photoName;
    }

    $users->save();

   return redirect()->route('usuario.index', $users)->with('success', '¡Usuario Creado Correctamente!');


    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User  $user)
    {
        $validator = Validator::make($request->all(), [
            'username'=> 'required|string|max:255|unique:users,usuario,', $user->id,
            'nombreusuario'=> 'required|string|max:255',
            'numerousuario'=> 'required|integer|max:8',
            'email' => 'required|string|email|max:255|unique:users,email,' ,$user->id,
            'password'=> 'required|string|min:8',
            'rolusuario'=>'required|string|max:255',
            'estadousuario'=>'required|string|max:255',
            'fotousuario'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){

            session(['error_id'=>$user->id]);
            return redirect()->route('usuario.index',$user->id)->withErrors($validator)->withInput()->with('error', 'Error al Actualizar Usuario, revise e intente nuevamente');
        }

        $user->update([
            'username'=>$request->input('usuario'),
        'nombreusuario'=>$request->input('nombreusuario'),
        'numerousuario'=>$request->input('numerousuario'),
        'email'=>$request->input('email'),
        'password'=>$request->input('password'),
        'rolusuario'=>$request->input('rolusuario'),
        'estadousuario'=>$request->input('estadousuario'),
        ]);
        if($request->has('password')){
            $hashedPassword=bcrypt($request->input('password'));
            $user->update(['password'=> $hashedPassword]);
        }
        
        if($request->hasFile('fotousuario')){
            if(Storage::disk('public')->exists($user->fotousuario)){
                Storage::disk('public')->delete($user->fotousuario);
            }
        
            $uploadedFile=$request->file('fotousuario');
            $photoName=$request->input('usuario') . '.' . $uploadedFile->getClientOriginalExtension();
            $photoPath=$uploadedFile->storeAs('public/usuarios', $photoName);
            $user->foto=$photoName;
        }
        $user->save();
        
                return redirect()->route('usuario.index')->with('success', '¡Usuario Actualizado Exitosamente!');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
