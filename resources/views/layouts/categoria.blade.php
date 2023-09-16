@extends('layouts.index')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')

<div class="container">
    <!-- Formulario para crear una nueva categoría -->
    <form method="POST" action="{{ route('categoria.store') }}">
       @csrf
       
        <div class="form-group row">
           <label for="nombre">Nombre de la Categoría</label>
           <input type="text" class="form-control @error('nombrecategoria') is-invalid @enderror"  id="nombrecategoria" name="nombrecategoria" required>
           @error('nombrecategoria')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group row">
           <label for="nombre">Tipo de la Categoría</label>
           <input type="text" class="form-control @error('nombrecategoria') is-invalid @enderror"  id="tipocategoria" name="tipocategoria" required>
           @error('nombrecategoria')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
        </div>
       
   
       <button type="submit" class="btn btn-primary">Agregar</button>
   </form>
</div>
<div class="container mt-4">
    <div class="container">
        <table id="categoriaTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
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
                @foreach($categorias as $categoria)
                    <tr>
                        <td>{{$categoria->id }}</td>
                        <td>{{$categoria->nombrecategoria }}</td>
                        <td>{{$categoria->tipocategoria}}</td>
                        <td>
                            {{-- <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-primary">Editar</a> --}}
                            <button class="btn btn-warning btn-edit" data-toggle="modal" data-target="#editarModal{{$categoria->id}}">Editar</button>
                            @if(!$categoria->categoria || $categoria->categoria->isEmpty())
                                <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#eliminarModal{{ $categoria->id }}">Eliminar</button>
                            @else
                                <!-- Mostrar boton deshanilitado si la categoría no puede ser eliminada -->
                                <button class="btn btn-danger btn-delete" disabled>Eliminar</button>
                            @endif
                        </td>
                        
                    </tr>
                    <div class="modal fade" id="editarModal{{ $categoria->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $categoria->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarModalLabel{{ $categoria->id }}">Editar Categoría</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de edición de categoría -->
                                    <form id="editarForm{{ $categoria->id }}" method="POST" action="{{ route('categoria.update', $categoria->id) }}">
                                        @csrf
                                        @method('PUT')
            
                                        <div class="form-group">
                                            <label for="nombre">Nombre de la Categoría</label>
                                            <input type="text" class="form-control" id="nombrecategoria" name="nombrecategoria" value="{{ $categoria->nombrecategoria }}" required>
                                            <label for="nombre">Tipo de la Categoría</label>
                                            <input type="text" class="form-control" id="tipocategoria" name="tipocategoria" value="{{ $categoria->tipocategoria }}" required>
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
                    
                    <div class="modal fade" id="eliminarModal{{ $categoria->id }}" tabindex="-1" aria-labelledby="eliminarModalLabel{{ $categoria->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eliminarModalLabel{{ $categoria->id }}">Eliminar Categoría</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de que quieres eliminar la categoría "{{ $categoria->nombrecategoria }}"?</p>
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="{{ route('categoria.destroy', $categoria->id) }}" style="display: inline;">
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
            <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="true">Listado de Categorías</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="create-tab" data-toggle="tab" href="#create" role="tab" aria-controls="create" aria-selected="false">Crear Categoría</a>
        </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">
        <!-- Pestaña de Listado de Categorías -->
        <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
           
    </div>
        
        <!-- Pestaña de Crear Categoría -->
        <div class="tab-pane fade" id="create" role="tabpanel" aria-labelledby="create-tab">
                       
        </div>
        
    </div> --}}
</div>

@endsection

@section('js')

<script>
    $(document).ready(function() {
    $('#categoriaTable').DataTable({
        "language": {
            "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json', // Ruta al archivo de idioma en español
        }
    });
});
</script>
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#agregarCategoriaForm');
        
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
        const modal = document.querySelector('#editarModal{{ $categoria->id }}');
        
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

</script>

@endif
@endsection


