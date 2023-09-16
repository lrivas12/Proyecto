@extends('layouts.index')
@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')

<div class="container">
    <!-- Formulario para crear un nuevo Cliente -->
    <form method="POST" action="{{ route('cliente.store') }}">
       @csrf
       
       <div class="form-group">
           <label for="nombre">Nombre del Cliente</label>
           <input type="text" class="form-control" id="nombrecliente" name="nombrecliente" required>
           <label for="nombre">Apellido del Cliente</label>
           <input type="text" class="form-control" id="apellidocliente" name="apellidocliente"required>
           <label for="nombre">Dirección del Cliente</label>
           <input type="text" class="form-control" id="direccioncliente" name="direccioncliente" >
           <label for="nombre">Teléfono del Cliente</label>
           <input type="text" class="form-control" id="telefonocliente" name="telefonocliente" >
           <label for="nombre">Correo del Cliente</label>
           <input type="email" class="form-control" id="correocliente" name="correocliente" >
            
        </div>
       
   
       <button type="submit" class="btn btn-primary">Agregar</button>
   </form>
</div>
<div class="container mt-4">
    <div class="container">
        <table id="clienteTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            {{-- @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif --}}
                @foreach($cliente as $cliente)
                    <tr>
                        <td>{{$cliente->id }}</td>
                        <td>{{$cliente->nombrecliente }}</td>
                        <td>{{$cliente->apellidocliente }}</td>
                        <td>{{$cliente->direccioncliente}}</td>
                        <td>{{$cliente->telefonocliente }}</td>
                        <td>{{$cliente->correocliente }}</td>
                        <td>
                            {{-- <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-primary">Editar</a> --}}
                            <button class="btn btn-primary btn-edit" data-toggle="modal" data-target="#editarModal{{$cliente->id}}">Editar</button>
                            <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#eliminarModal{{ $cliente->id }}">Eliminar</button>
                            
                        </td>
                        
                    </tr>
                    <div class="modal fade" id="editarModal{{ $cliente->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $cliente->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarModalLabel{{ $cliente->id }}">Editar Cliente</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de edición de categoría -->
                                    <form id="editarForm{{ $cliente->id }}" method="POST" action="{{ route('cliente.update', $cliente->id) }}">
                                        @csrf
                                        @method('PUT')
            
                                        <div class="form-group">
                                            <label for="nombre">Nombre del Cliente</label>
                                            <input type="text" class="form-control" id="nombrecliente" name="nombrecliente" value="{{ $cliente->nombrecliente }}" required>
                                            <label for="nombre">Apellido del Cliente</label>
                                            <input type="text" class="form-control" id="apellidocliente" name="apellidocliente" value="{{ $cliente->apellidocliente }}" required>
                                            <label for="nombre">Dirección del Cliente</label>
                                            <input type="text" class="form-control" id="direccioncliente" name="direccioncliente" value="{{ $cliente->direccioncliente }}" >
                                            <label for="nombre">Teléfono del Cliente</label>
                                            <input type="text" class="form-control" id="telefonocliente" name="telefonocliente" value="{{ $cliente->telefonocliente }}" >
                                            <label for="nombre">Correo del Cliente</label>
                                            <input type="email" class="form-control" id="correocliente" name="correocliente" value="{{ $cliente->correocliente }}" >
                                            </div>
            
                                        <button type="submit" class="btn btn-primary btn-submit">Guardar Cambios</button>
                                       
                                         
                                        
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="eliminarModal{{ $cliente->id }}" tabindex="-1" aria-labelledby="eliminarModalLabel{{ $cliente->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eliminarModalLabel{{ $cliente->id }}">Eliminar Cliente</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de que quieres eliminar el cliente "{{ $cliente->nombrecliente }}"?</p>
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="{{ route('cliente.destroy', $cliente->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    
                @endforeach
            </tbody>
        </table>
    </div>

    
   {{--  <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true">Listado de Clientes</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="create-tab" data-toggle="tab" href="#create" role="tab" aria-controls="create" aria-selected="false">Crear Clientes</a>
        </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">
        <!-- Pestaña de Listado de Clientes -->
        <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
           
    </div>
        
        <!-- Pestaña de Crear Clientes -->
        <div class="tab-pane fade" id="create" role="tabpanel" aria-labelledby="create-tab">
                       
        </div>
        
    </div> --}}
</div>

@endsection

@section('js')

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#agregarClienteForm');
        
        if (form) {

            const btnSubmit = form.querySelector('[type="submit"]');
            
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Éxito',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 500
                }).then(() => {
                    btnSubmit.disabled = true;
                    this.submit();
                    location.reload();
                });
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.querySelector('#eliminarModal{{$cliente->id}}');
        
        if (modal) {
            const modalBody = modal.querySelector('.modal-body');
            
             Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 500
            }).then(() => {
                /* modalBody.innerHTML = ''; // Limpiar el contenido del modal
                modal.classList.remove('show'); // Ocultar el modal
                modal.style.display = 'none'; // Ocultar el modal (Bootstrap)
                document.body.classList.remove('modal-open'); // Habilitar el scroll
                document.body.style.paddingRight = '0px'; // Restaurar el padding */
                location.reload();  // Recargar la página
            }); 

           
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.querySelector('#editarModal{{ $medida->id }}');
        
        if (modal) {
            const modalBody = modal.querySelector('.modal-body');
            
             Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                
                location.reload();  // Recargar la página
            }); 

           
        }
    });
</script>

@endif

<script>
    $(document).ready(function() {
    $('#clienteTable').DataTable({
        "language": {
            "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json', // Ruta al archivo de idioma en español
        }
    });
});
</script>
@endsection