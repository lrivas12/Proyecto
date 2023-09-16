<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cliente;

class clienteController extends Controller
{
     public function index()
     {
        $cliente = cliente::all();
        return view ('layouts.cliente', compact('cliente')); 
     }

     public function store(Request $request)
     {
        $request->validate([
            'nombrecliente' => 'required|string|max:255',
            'apellidocliente' => 'required|string|max:255',
            'direccioncliente' => 'string|max:255',
            'telefonocliente' => 'string|max:8',
            'correocliente' => 'string|max:255',
        ]);
        $cliente = new Cliente();
        $cliente->nombrecliente = $request->input('nombrecliente');
        $cliente->apellidocliente = $request->input('apellidocliente');
        $cliente->direccioncliente = $request->input('direccioncliente');
        $cliente->telefonocliente = $request->input('telefonocliente');
        $cliente->correocliente = $request->input('correocliente');
        $cliente->save();
    
        return redirect()->route('cliente.index')->with('success', 'Cliente Almacenado exitosamente');
     }

     public function edit(cliente $cliente, $id)
     {
        $cliente = cliente::findOrFail($id);

        return view('cliente.index', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = cliente::findOrFail($id);
         $request->validate([

            'nombrecliente' => 'required|string|max:255',
            'apellidocliente' => 'required|string|max:255',
            'direccioncliente' => 'string|max:255',
            'telefonocliente' => 'string|max:255',
            'correocliente' => '|string|max:255',
        
         ]);
         
        $cliente->nombrecliente = $request->input('nombrecliente');
        $cliente->apellidocliente = $request->input('apellidocliente');
        $cliente->direccioncliente = $request->input('direccioncliente');
        $cliente->telefonocliente = $request->input('telefonocliente');
        $cliente->correocliente = $request->input('correocliente');
        $cliente->save();
        
        return redirect()->route('cliente.index')->With('success', 'Cliente actualizado correctamente');

    }

    public function destroy($id)
    {
        $clientes = cliente::findOrFail($id);
        $clientes->delete();
            return redirect()->route('cliente.index')->with('success', 'Cliente eliminado correctamente');
    
    }
}