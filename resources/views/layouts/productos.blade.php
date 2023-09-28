@extends('layouts.index')

@section('title', 'Productos')
@section('css')
    <style>
        .modal {
            display: none;
        }

        .mini-formulario {
            display: none;
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .section {
            display: flex;
            justify-content: space-between;
        }

        .fa-question-circle {
            font-size: 27px;
        }
    </style>

@stop
@section('content_header')
    <section class="section">
        <h1> Productos</h1>
    <i class="btn far fa-question-circle" title="Ayuda"></i>
    </section>
    <hr class="my-2" />
@stop

@section('content')
<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-shopping-bag"></i> Nuevo Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form method= "POST" action="{{route ('producto.store')}}">
                    @csrf
                    <div class="form-group row">
                        <label for="fotoproducto">Foto: </label>
                        <input type="file" name="fotoproducto" id="fotoproducto" class="form-control" value="{{ old('fotoproducto')}}">
                    </div>
                    <div class="form-group row">
                        <label for="nombreproducto">Nombre Producto: </label>
                        <input type="text" class="form-control" id="nombreproducto" name="nombreproducto" value="{{ old('nombreproducto')}}" required autocomplete="nombreproducto" autofocus >
                        @error('nombreproducto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="categoria">Categoría: </label>
                        <select name="id_categoria" id="id_categoria">
                            <option value="">Seleccionar una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="descripcionproducto">Descripción Producto: </label>
                        <input type="text" class="form-control" id="descripcionproducto" name="descripcionproducto" value="{{ old('descripcionproducto')}}" autocomplete="descripcionproducto" autofocus >
                        @error('descripcionproducto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="clasificacionproducto">Clasificación Producto: </label>
                        <select id="privilegios"
                        class="form-control @error('clasificacionproducto') is-invalid @enderror"
                        name="clasificacionproducto" required autocomplete="clasificacionproducto">
                        <option
                        value="TipoA"{{ old('clasificacionproducto') === 'Tipoa A' ? ' selected' : '' }}>
                        Tipo A</option>
                        <option
                        value="TipoB"{{ old('clasificacionproducto') === 'Tipo B' ? ' selected' : '' }}>
                        Tipo B</option>
                        @error('clasificacionproducto')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                        <label for="cantidadproducto">Cantidad Producto: </label>
                        <input type="number" class="form-control" id="cantidadproducto" name="cantidadproducto" value="{{ old('cantidadproducto')}}" required autocomplete="cantidadproducto" autofocus >
                        @error('cantidadproducto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> 
                    <div class="form-group row">
                        <label for="precioproducto">Precio Producto: </label>
                        <input type="number" class="form-control" id="precioproducto" name="precioproducto" value="{{ old('precioproducto')}}" required autocomplete="precioproducto" autofocus >
                        @error('precioproducto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="marcaproducto">Marca Producto: </label>
                        <input type="text" class="form-control" id="marcaproducto" name="marcaproducto" value="{{ old('marcaproducto')}}" required autocomplete="marcaproducto" autofocus >
                        @error('marcaproducto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="unidadmedidaproducto">Unidad de Medida Producto: </label>
                        <input type="text" class="form-control" id="unidadmedidaproducto" name="unidadmedidaproducto" value="{{ old('unidadmedidaproducto')}}" required autocomplete="unidadmedidaproducto" autofocus >
                        @error('unidadmedidaproducto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="	far fa-window-close"></i> Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modelId"><i class="fas fa-plus"></i> Agregar Nuevo Producto</button>
<br><br>
<table id="productosTable" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Imagen </th>
            <th>Nombre </th>
            <th>Categoría</th>
            <th>Descripción </th>
            <th>Clasificación</th>
            <th>Cantidad </th>
            <th>Precio </th>
            <th>Marca</th>
            <th>Unidad de Medida</th>
            <th>Acciones</th>
        </tr>
    </thead>
     <tbody>
        @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombreproducto }}</td>
                <td>{{ $producto->descripcionproducto }}</td>
                <td>{{ $producto->cantidadproducto }}</td>
                <td>{{ $producto->precioproducto }}</td>
                <td>{{ $producto->marcaproducto }}</td>
                <td>{{$producto->clasificacionproducto}}</td>
                <td>{{ $producto->unidadmedidaproducto }}</td>
                <td>{{$producto->categoria->id_categoria}}</td>
                <td>
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>
                            @if ($producto->fotoproducto)
                                <img src="{{ asset('storage/producto/' . $producto->fotoproducto) }}"
                                    style="max-width: 50px; border-radius: 50%;">
                            @else
                                <img src="{{ asset('storage/producto/Placeholderproducto.jpg') }}"
                                    alt="Imagen por defecto">
                        </td>
                @endif
                    <button class="btn btn-warning btn-edit" data-toggle="modal" data-target="#editarModal{{$producto->id}}"><i class="fas fa-edit"></i> Editar</button>
                </td>
            </tr>
            <div class="modal fade" id="editarModal{{ $producto->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $producto->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="editarModalLabel{{ $producto->id }}"><i class="fas fa-edit"></i> Editar Producto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario de edición de producto -->
                            <form method="POST" action="{{ route('producto.update', $producto->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nombreproductoE">Nombre Producto:</label>
                                    <input type="text" class="form-control @error('nombreproductoE') is-invalid @enderror" id="nombreproductoE" name="nombreproductoE" value="{{ old('nombreproductoE', $producto->nombreproducto )}}" required autocomplete="nombreproductoE" autofocus>
                                    @error('nombreproductoE')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="descripcionproductoE">Descripcion Producto:</label>
                                    <input type="text" class="form-control @error('descripcionproductoE') is-invalid @enderror" id="descripcionproductoE" name="descripcionproductoE" value="{{ old('descripcionproductoE', $producto->descripcionproducto )}}" autocomplete="descripcionproductoE" autofocus>
                                    @error('descripcionproductoE')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="cantidadproductoE">Cantidad Producto:</label>
                                    <input type="number" class="form-control @error('cantidadproductoE') is-invalid @enderror" id="cantidadproductoE" name="cantidadproductoE" value="{{ old('cantidadproductoE', $producto->cantidadproducto )}}" required autocomplete="cantidadproductoE" autofocus >
                                    @error('cantidadproductoE')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="precioproductoE">Precio Producto:</label>
                                    <input type="number" class="form-control @error('precioproductoE') is-invalid @enderror" id="precioproductoE" name="precioproductoE" value="{{ old('precioproductoE', $producto->precioproducto )}}" required autocomplete="precioproductoE" autofocus >
                                    @error('precioproductoE')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>         
                                <div class="form-group">
                                    <label for="marcaproductoE">Marca Producto:</label>
                                    <input type="text" class="form-control @error('marcaproductoE') is-invalid @enderror" id="marcaproductoE" name="marcaproductoE" value="{{ old('marcaproductoE', $producto->marcaproducto )}}" required autocomplete="marcaproductoE" autofocus >
                                    @error('marcaproductoE')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="unidadmedidaproductoE">Unidad de Medida Producto:</label>
                                    <input type="text" class="form-control @error('unidadmedidaproductoE') is-invalid @enderror" id="unidadmedidaproductoE" name="unidadmedidaproductoE" value="{{ old('unidadmedidaproductoE', $producto->unidadmedidaproducto )}}" required autocomplete="unidadmedidaproductoE" autofocus >
                                    @error('unidadmedidaproductoE')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="	far fa-window-close"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
    </tbody> 
</table>

@endsection

@section('js')
<script>
$(document).ready(function() {
$('#productosTable').DataTable({
"language": {
    "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json', // Ruta al archivo de idioma en español
},
dom:'Bfrtilp',
buttons:[{
    extend:'print',
    text: '<i class="fas fa-print"> Imprimir</i>',
    className:'btn btn-info'
},
] 
});
});
</script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@endsection