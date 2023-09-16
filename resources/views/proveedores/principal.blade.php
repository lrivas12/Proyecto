@extends('layouts.index')

@section('title', 'Proveedores')

@section('content_header')
    <h1>Proveedores</h1>
@stop

@section('content')
<div class="container">
 <!-- Formulario para crear un proveedor-->
 <form method="POST" action="{{ route('proveedores.store') }}">
    @csrf
    
    <div class="form-group">
        <label for="razonsocialproveedor">Razon social o nombre</label>
        <input type="text" class="form-control" id="razonsocialproveedor" name="razonsocialproveedor" required>
    </div>
    <div class="form-group">
        <label for="numerorucproveedor">Numero Ruc</label>
        <input type="text" class="form-control" id="numerorucproveedor" name="numerorucproveedor" required>
    </div>
    <div class="form-group">
        <label for="estadoproveedor">Estado</label>
        <input type="text" class="form-control" id="estadoproveedor" name="estadoproveedor" required>
    </div>

    <button type="submit" class="btn btn-primary">Agregar</button>
</form>
</div>
<div class="container mt-4">
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Razon social o nombre</th>
                    <th>Numero Ruc</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->razonsocialproveedor }}</td>
                        <td>{{ $proveedor->numerorucproveedor }}</td>
                        <td>{{ $proveedor->estadoproveedor }}</td>
                        <td>
                            {{-- <a href="{{ route('medidas.edit', $medida->id) }}" class="btn btn-primary">Editar</a> --}}
                            <button class="btn btn-primary btn-edit" data-toggle="modal" data-target="#editarModal{{$proveedor->id}}">Editar</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editarModal{{ $proveedor->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $proveedor->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarModalLabel{{ $proveedor->id }}">Editar proveedor</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de edición de proveedor -->
                                    <form method="POST" action="{{ route('proveedores.update', $proveedor->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="razonsocialproveedor">Razon social o nombre</label>
                                            <input type="text" class="form-control" id="razonsocialproveedor" name="razonsocialproveedor" value="{{ $proveedor->razonsocialproveedor }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="numerorucproveedor">Numero Ruc</label>
                                            <input type="text" class="form-control" id="numerorucproveedor" name="numerorucproveedor" value="{{ $proveedor->numerorucproveedor }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="estadoproveedor">Estado</label>
                                            <input type="text" class="form-control" id="estadoproveedor" name="estadoproveedor" value="{{ $proveedor->estadoproveedor }}" required>
                                        </div>         
                                      
            
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

   
</div>
@endsection