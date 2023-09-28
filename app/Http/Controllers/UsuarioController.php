<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\MustVerifyEmail;

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
            'usuario'=> 'required|string|max:255|unique:users,usuario,',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'password'=> 'required|string|min:8',
            'privilegios'=>'required|string|max:255',
            'foto'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return redirect()->route('usuario.index')->withErrors($validator)->withInput()->with('errorC', 'Error al crear el Usuario, revise e intente nuevamente');
        }

        $hashedPassword = bcrypt($request->input('password'));

        $users = User::create([
        'usuario'=>$request->input('usuario'),
        'email'=>$request->input('email'),
'password'=>$request->input('password'),
'privilegios'=>$request->input('privilegios'),
'estado'=>$request->input('estado'),
'password'=>$hashedPassword,
        ]);

        if($request->hasFile('foto')){
            $uploadedFile=$request->file('foto');
            $photoName=Str::slug($users->usuario) . '.' . $uploadedFile->getClientOriginalExtension();
        $photoPath=$uploadedFile->storeAs('public/usuarios', $photoName);
        $users->foto=$photoName;
        }

        $users->save();

       return redirect()->route('usuario.index', $users)->with('successC', '¡Usuario Creado Correctamente!');
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
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'usuario'=> 'required|string|max:255|unique:users,usuario,' .$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'  .$user->id,
            'password'=> 'required|string|min:8',
            'privilegios'=>'required|string|max:255',
            'foto'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){

            session(['error_id'=>$user->id]);
            return redirect()->route('usuario.index',$user->id)->withErrors($validator)->withInput()->with('error', 'Error al Actualizar Usuario, revise e intente nuevamente');
        }

        $user->update([
            'usuario'=>$request->input('usuario'),
            'email'=>$request->input('email'),
            'password'=>$request->input('password'),
            'privilegios'=>$request->input('privilegios'),
            'estado'=>$request->input('estado'),
        ]);

        $user->sendEmailVerificationNotification();

        if($request->has('password')){
            $hashedPassword=bcrypt($request->input('password'));
            $user->update(['password'=> $hashedPassword]);
        }

        if($request->hasFile('foto')){
            if(Storage::disk('public')->exists($user->foto)){
                 Storage::disk('public')->delete($user->foto);
            }

            $uploadedFile=$request->file('foto');
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
    public function DesactivarUsuario($id)
    {
        $user = User::findOrFail($id);

        // Cambia el estado del usuario (1 para activar, 0 para desactivar)
        $user->estado = $user->estado == 1 ? 0 : 1;
        $user->save();

        return redirect()->back()->with('success', 'Usuario Actualizado Exitosamente');
    }
}