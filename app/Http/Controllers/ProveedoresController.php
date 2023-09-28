<?php

namespace App\Http\Controllers;

use App\Models\proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProveedoresController extends Controller
{
   public function index()
   {
    $proveedores=proveedores::all();
    return view('proveedores.principal', compact('proveedores'));
    
   }

   public function store(Request $request)
   {
    $validator = Validator::make ($request->all(),[
    'razonsocialproveedor' => 'required|string|max:40',
    'numerorucproveedor' => 'string|max:20',
    'estadoproveedor' => 'required|string',
    'telefonoproveedor'=> 'string|max:8',

]);
    
    $customMessages =[
    'required' => 'El Campo :atribute es Obligatorio',
    'max' => 'El Campo :atribute no debe superar :max caracteres',
    ];

    $validator->setCustomMessages($customMessages);
    if($validator->fails()){

    return redirect()->route('proveedores.index') ->withErrors($validator)->withInput()->with('errorC','Error al crear proveedor, revise e intente nuevamente.');
   }
   $proveedores = proveedores::create([
    'razonsocialproveedor' => $request->input('razonsocialproveedor'),
    'numerorucproveedor' => $request->input('numerorucproveedor'),
    'estadoproveedor' => $request->input('estadoproveedor'),
    'telefonoproveedor' => $request->input('telefonoproveedor'),
   ]);

    $proveedores->save();
    return redirect()->route('proveedores.index', $proveedores)->with('successC','Proveedor creado con exito');
}

   public function edit($id)
   {

    $proveedores=proveedores::findOrFail($id);
    return view('proveedores.edit',compact('proveedores'));
   }


   public function update(Request $request, $id)
   {
    $proveedores = proveedores::findOrFail($id);
    
    $validator = Validator::make ($request->all(),[
        'razonsocialproveedor' => 'required|string|max:40',
        'numerorucproveedor' => 'string|max:20',
        'estadoproveedor' => 'required|string',
        'telefonoproveedor'=> 'string|max:8',
    ]);
    $customMessages =[
        'required' => 'El Campo :atribute es Obligatorio',
        'max' => 'El Campo :atribute no debe superar :max caracteres',
        ];
    
    $validator->setCustomMessages($customMessages);

    if($validator->fails())
    {
    return redirect()->route('proveedores.index', $proveedores->id)->withErrors($validator)->withInput()->with('error', 'Error al actualizar proveedor, revise e intente nuevamente');
    }
   
    $proveedores->update([

        'razonsocialproveedor' => $request->input('razonsocialproveedorE'),
        'numerorucproveedor' => $request->input('numerorucproveedorE'),
        'estadoproveedor' => $request->input('estadoproveedorE'),
        'telefonoproveedor' => $request->input('telefonoproveedorE'),
       
    ]);
    $proveedores->save();
    return redirect()->route('proveedores.index')->with('success','Proveedor actualizado con exito');
   }

   public function destroy($id)
   {
    $proveedores=proveedores::findOrFail($id);

    $proveedores->delete();

    return redirect()->route('proveedores.index')->with('success','proveedor borrado exitosamente');
   }
}