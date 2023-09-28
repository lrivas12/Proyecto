<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\producto;
use App\Models\categoria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProductoController extends Controller
{
    public function index()
    {
        $productos = producto::all();
        $categorias = categoria::all();
        return view ('layouts.productos', compact('productos', 'categorias'));
    }

    public function edit($id)
    {
        $productos = producto::findOrFail($id);
        $categorias = categoria::findOrFail($id);
        return view ('producto.index', compact('productos, categorias'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreproducto' => 'required|string|max:255',
            'descripcionproducto' => 'string|max:255',
            'precioproducto' => 'required|numeric|min:0',
            'cantidadproducto' => 'required|integer|min:0',
            'marcaproducto' => 'required|string|max:255',
            'unidadmedidaproducto' => 'required|string|max:255',
            'clasificacionproducto' => 'required|string|max:255',
            'id_categoria' => 'required|exists:categorias,id',
            'fotoproducto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $customMessages =[
            'required' => 'El Campo :atribute es Obligatorio',
            'max' => 'El Campo :atribute no debe superar :max caracteres',
            'min' => 'El Campo :atribute  debe superar :min caracteres',
            ];
        
            $validator->setCustomMessages($customMessages);
        
        
        if ($validator->fails()) {
            return redirect()->route('producto.index')->withErrors($validator)->withInput()->with('errorC','Error al crear el producto revise e intente nuevamente');
        }

        $productos = new Producto();
        $productos->nombreproducto = $request->input('nombreproducto');
        $productos->descripcionproducto = $request->input('descripcionproducto');
        $productos->cantidadproducto = $request->input('cantidadproducto');
        $productos->marcaproducto = $request->input('marcaproducto');
        $productos->unidadmedidaproducto = $request->input('unidadmedidaproducto');
        $productos->precioproducto = $request->input('precioproducto');
        $productos->clasificacionproducto = $request->input('clasificacionproducto');
        $productos->id_categoria = $request->input('id_categoria');
        $imageName = Str::slug($productos->nombreproducto) . '.' . $request->file('fotoproducto')->getClientOriginalExtension();
    
        if ($request->hasFile('fotoproducto')) {
            $imagenPath = $request->file('fotoproducto')->store('productos');
            $productos->fotoproducto = $imagenPath;
        }

        $productos->save();

        return redirect()->route('producto.index')->with('successC', 'Producto creado con éxito');
    
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombreproducto' => 'required|string|max:255',
            'descripcionproducto' => 'string|max:255',
            'precioproducto' => 'required|numeric|min:0',
            'cantidadproducto' => 'required|integer|min:0',
            'marcaproducto' => 'required|string|max:255',
            'unidadmedidaproducto' => 'required|string|max:255',
            'clasificacionproducto' => 'required|string|max:255',
            'id_categoria' => 'required|exists:categorias,id',
            'fotoproducto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $customMessages =[
            'required' => 'El Campo :atribute es Obligatorio',
            'max' => 'El Campo :atribute no debe superar :max caracteres',
            ];
        
        $validator->setCustomMessages($customMessages);
    
        if ($validator->fails()) {
            return redirect()->route('producto.index', $id)->withErrors($validator)->withInput()->with('errorC','Error al crear el producto revise e intente nuevamente');
        
        }

        $productos = producto::find($id);
        $productos->nombreproducto = $request->input('nombreproductoE');
        $productos->descripcionproducto = $request->input('descripcionproductoE');
        $productos->cantidadproducto = $request->input('cantidadproductoE');
        $productos->marcaproducto = $request->input('marcaproductoE');
        $productos->unidadmedidaproducto = $request->input('unidadmedidaproductoE');
        $productos->precioproducto = $request->input('precioproductoE');
        $productos->clasificacionproducto = $request->input('clasificacionproductoE');
        $productos->id_categoria = $request->input('id_categoria');
        $imageName = Str::slug($productos->nombreproducto) . '.' . $request->file('fotoproducto')->getClientOriginalExtension();
            
        if ($request->hasFile('fotoproducto')) {
            $imagenPath = $request->file('fotoproducto')->store('productos');
            $productos->fotoproducto = $imagenPath;
        }


        $productos->save();

        return redirect()->route('producto.index')->with('success', 'Producto actualizado con éxito');
    }
    
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if ($producto->fotoproducto) {
            Storage::delete($producto->fotoproducto);
        }

        $producto->delete();

        return redirect()->route('producto.index')->with('success', 'Producto eliminado con éxito');
    }
}
