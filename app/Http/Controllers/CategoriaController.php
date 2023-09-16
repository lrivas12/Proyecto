<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categoria;

class categoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = categoria::all();
        return view('layouts.categoria', compact('categorias'));    
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
        $request->validate([
            'nombrecategoria' => 'required|string|max:255',
            'tipocategoria' => 'required|string|max:255',
        ]);
        categoria::Create($request->all());

        return redirect()->route('categoria.index')->with('success', 'Categoria almacenada exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categoria $categoria, $id)
    {
        $categorias = categoria::findOrFail($id);
        return view('categoria.index', compact('categorias'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categorias = categoria::findOrFail($id);
        $request->validate([
            'nombrecategoria' => 'required|string|max:255',
            'tipocategoria' => 'required|string|max:255',
        ]);
        $categorias->update($request->all());

        return redirect()->route('categoria.index')->With('success', 'Categoria actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $categorias = categoria::findOrFail($id);
        $categorias->delete();
            return redirect()->route('categoria.index')->with('success', 'Categoría eliminada correctamente');
    }
}