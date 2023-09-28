@extends('layouts.index')

@section('title', 'Proveedores')

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
        <h1>Proveedores</h1>
        <i class="btn far fa-question-circle" title="Ayuda"></i>
    </section>
    <hr class="my-2" />
@stop

@section('content')
<div class="card">
<div class="card-body">
 <!-- Formulario para crear un proveedor-->
 <form method="POST" action="{{ route('proveedores.store') }}">
    @csrf
    
    <div class="form-group">
        <label for="razonsocialproveedor">Razon Social o Nombre Proveedor:</label>
        <input type="text" class="form-control @error('razonsocialproveedor') is-invalid @enderror" id="razonsocialproveedor" name="razonsocialproveedor" value="{{ old('razonsocialproveedor')}}" required autocomplete="razonsocialproveedor" autofocus>
        @error('razonsocialproveedor')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    <div class="form-group">
        <label for="numerorucproveedor">Numero Ruc Proveedor: </label>
        <input type="text" class="form-control @error('numerorucproveedor') is-invalid @enderror" id="numerorucproveedor" name="numerorucproveedor" autocomplete="numerorucproveedor" value="{{ old('numerorucproveedor')}}" autofocus>
        @error('numerorucproveedor')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    <div class="form-group">
        <label for="estadoproveedor">Estado Proveedor: </label>
        <input type="text" class="form-control @error('estadoproveedor') is-invalid @enderror" id="estadoproveedor" name="estadoproveedor" required autocomplete="estadoproveedor" value="{{ old('estadoproveedor')}}" autofocus>
        @error('estadoproveedor')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    <div class="form-group">
        <label for="telefonoproveedor">Teléfono Proveedor: </label>
        <input type="text" class="form-control @error('telefonoproveedor') is-invalid @enderror" id="telefonoproveedor" name="telefonoproveedor" autocomplete="telefonoproveedor" value="{{ old('telefonoproveedor')}}" autofocus>
        @error('telefonoproveedor')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    <br>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Agregar</button>
</form>
</div>
</div>
<br>
<h2>Lista de Proveedores</h2>
        <table id="proveedor" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Razon Social o Nombre</th>
                    <th>Numero Ruc</th>
                    <th>Estado</th>
                    <th>Teléfono</th>
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
                        <td>{{ $proveedor->telefonoproveedor }}</td>
                        <td>
                            {{-- <a href="{{ route('medidas.edit', $medida->id) }}" class="btn btn-primary">Editar</a> --}}
                            <button class="btn btn-warning btn-edit" data-toggle="modal" data-target="#editarModal{{$proveedor->id}}"><i class="fas fa-edit"></i> Editar</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editarModal{{ $proveedor->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $proveedor->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center" id="editarModalLabel{{ $proveedor->id }}"><i class="fas fa-edit"></i> Editar proveedor</h5>
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
                                            <label for="razonsocialproveedor">Razon Social o Nombre Proveedor: </label>
                                            <input type="text" class="form-control @error('razonsocialproveedorE') is-invalid @enderror" id="razonsocialproveedorE" name="razonsocialproveedorE" value="{{ old('razonsocialproveedorE', $proveedor->razonsocialproveedor) }}" required autocomplete="razonsocialproveedorE" autofocus>
                                            @error('razonsocialproveedorE')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="numerorucproveedor">Numero Ruc Proveedor: </label>
                                            <input type="text" class="form-control @error('numerorucproveedorE') is-invalid @enderror" id="numerorucproveedorE" name="numerorucproveedorE" value="{{ old('razonsocialproveedorE', $proveedor->numerorucproveedor) }}" required autocomplete="razonsocialproveedorE" autofocus>
                                            @error('numerorucproveedorE')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="estadoproveedor">Estado Proveedor: </label>
                                            <input type="text" class="form-control @error('estadoproveedorE') is-invalid @enderror"  id="estadoproveedorE" name="estadoproveedorE" value="{{ old('estadoproveedorE', $proveedor->estadoproveedor) }}" autocomplete="estadoproveedorE" autofocus>
                                            @error('estadoproveedorE')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                         @enderror

                                        </div>         
                                        <div class="form-group">
                                            <label for="telefonoproveedor">Teléfono Proveedor: </label>
                                            <input type="text" class="form-control @error('telefonoproveedorE') is-invalid @enderror" id="telefonoproveedorE" name="telefonoproveedorE" value="{{ old('telefonoproveedorE', $proveedor->telefonoproveedor) }}"  autocomplete="telefonoproveedorE" autofocus>
                                            @error('telefonoproveedorE')
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


@section('js')
<script>
    $(document).ready(function() {
    $('#proveedor').DataTable({
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
@endsection

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@endsection
