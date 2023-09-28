@extends('layouts.index')

@section('title', 'Usuarios')

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
        <h1><i class="fa fa-user-circle"></i> Usuarios</h1>
        <i class="btn far fa-question-circle" title="Ayuda"></i>
    </section>
    <hr class="my-2" />
@stop


@section('content')

    <a id="userModalBtn" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal" data-whatever="@mdo">
        <i class="fas fa-user-plus"></i> Crear
        Usuario</a><br><br>

    <div class="row justify-content-center card">
        <div class="col-md-15x">
            <div class="card-body">
                <h3>Listado de Usuarios</h3>
                <div>
                    <table id="userTable" class="table table-hover table-bordered">
                        <thead class="thead-blue">
                            <tr>
                                <th>Id</th>
                                <th>Fotografía</th>
                                <th>Usuario</th>
                                <th>Correo Electrónico</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        @if ($user->foto)
                                            <img src="{{ asset('storage/usuarios/' . $user->foto) }}"
                                                style="max-width: 50px; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('storage/usuarios/PlaceholderUser.jpg') }}"
                                                alt="Imagen por defecto">
                                    </td>
                            @endif
                            </td>
                            <td>{{ $user->usuario }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->privilegios }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button type="button" title="Editar Usuario" class="btn btn-link" data-toggle="modal"
                                        data-target="#editUserModal{{ $user->id }}">
                                        <i class="fas fa-edit text-warning"></i>
                                    </button>
                                    <a>
                                       
                                        <form method="POST" action="{{ route('usuario.desactivate', ['id' => $user->id]) }}">
                                            @csrf
                                            @if ($user->estado == 1)
                                                <input type="hidden" name="estado" value="0">
                                                <button type="submit" title="Desactivar Usuario" class="btn btn-link"><i
                                                        class="fas fa-user-check text-success"></i></button>
                                            @else
                                                <input type="hidden" name="estado" value="1">
                                                <button type="submit" title="Activar Usuario" class="btn btn-link"><i
                                                        class="fas fa-user-minus text-danger"></i></button>
                                            @endif
                                        </form>
                                    </a>
                                </div>

                                {{--  @csrf
                                                @method('PUT')
                                                @if ($user->is_active)
                                                    <a href="{{ route('users.deactivate', $user->id) }}" class="btn btn-danger btn-sm">Desactivar</a>
                                                @else
                                                @method('PUT')
                                                    <a href="{{ route('users.activate', $user->id) }}"   class="btn btn-success btn-sm">Activar</a>
                                                @endif --}}

                            </td>
                            </tr>

                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Editar Usuario</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('usuario.update', $user->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-group row">
                                                    <label for="photo"
                                                        class="col-md-4 col-form-label text-md-right">Fotografía</label>
                                                    <br>

                                                    <div class="col-md-6">
                                                        @if ($user->foto)
                                                            <div class="current-image">
                                                                <img src="{{ asset('storage/usuarios/' . $user->foto) }}"
                                                                    alt="Vista previa de "
                                                                    style="display: none; max-width: 100px; border-radius: 50%;">
                                                            </div>
                                                        @else
                                                            <p>No hay imagen</p>
                                                        @endif
                                                        <div class="form-group">
                                                            <br>
                                                            <input type="file"
                                                                class="form-control-file @error('foto') is-invalid @enderror"
                                                                name="foto" id="foto" accept="image/*"
                                                                onchange="previewImage(event)">
                                                            <br>
                                                        </div>

                                                        @error('foto')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="usuario"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Usuario:') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="usuario" type="text"
                                                            class="form-control @error('usuario') is-invalid @enderror"
                                                            name="usuario" value="{{ old('usuario', $user->usuario) }}"
                                                            required autocomplete="usuario" autofocus>

                                                        @error('usuario')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="email"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico:') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="email" type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email', $user->email) }}"
                                                            required autocomplete="email">

                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="rol"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Rol:') }}</label>

                                                    <div class="col-md-6">
                                                        <select id="privilegios"
                                                            class="form-control @error('privilegios') is-invalid @enderror"
                                                            name="privilegios" required autocomplete="privilegios">
                                                            <option
                                                                value="Administrador"{{ old('privilegios', $user->privilegios) === 'Administrador' ? ' selected' : '' }}>
                                                                Administrador</option>
                                                            <option
                                                                value="Doctor"{{ old('privilegios', $user->privilegios) === 'Editor' ? ' selected' : '' }}>
                                                                Editor</option>
                                                            

                                                        @error('privilegios')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>




                                                <div class="form-group row">
                                                    <label for="password"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Contraseña:') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="password" type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" autocomplete="new-password">

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="password-confirm"
                                                        class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña:') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="password-confirm" type="password" class="form-control"
                                                            name="password_confirmation" autocomplete="new-password">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Cancelar</button>
                                                    <button id="usereditado" type="submit" class="btn btn-primary">
                                                        {{ __('Actualizar') }}
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus"></i> Nuevo Usuario</h5>
                    <button id="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('usuario.store') }}" enctype="multipart/form-data">

                        @csrf

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">Fotografía</label>
                            <br>
                            <div class="col-md-6">

                                <img id="photoPreview" src="" alt="Vista previa de la foto de perfil"
                                    style="display: none; max-width: 100px; border-radius: 50%;">
                                <br>
                                <input type="file" class="form-control-file @error('foto') is-invalid @enderror"
                                    name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
                                <br>
                                @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="usuario"
                                class="col-md-4 col-form-label text-md-right">{{ __('Usuario:') }}</label>

                            <div class="col-md-6">
                                <input id="usuario" type="text"
                                    class="form-control @error('usuario') is-invalid @enderror" name="usuario"
                                    value="{{ old('usuario') }}" required autocomplete="usuario" autofocus>


                                @error('usuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="privilegios"
                                class="col-md-4 col-form-label text-md-right">{{ __('Rol:') }}</label>

                            <div class="col-md-6">
                                <select id="seleccion" class="form-control @error('privilegios') is-invalid @enderror"
                                    name="privilegios" required onchange="mostrarMiniFormulario()">
                                    <option value="">---Selecciona un Rol---</option>
                                    <option value="Administrador"
                                        {{ old('privilegios') === 'Administrador' ? ' selected' : '' }}>
                                        Administrador
                                    </option>
                                    <option value="Editor" {{ old('privilegios') === 'Editor' ? ' selected' : '' }}>
                                        Editor
                                    </option>
                                    
                                </select>

                                @error('privilegios')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="mini-formulario" id="miniFormulario">
                            <h3 class="text-center">Datos del Doctor</h3>
                            <div class="form-group row">
                                <label for=""
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nombre:') }}</label>
                                <div class="col-md-6">
                                    <input id="" type="text"
                                        class="form-control @error('') is-invalid @enderror" name=""
                                        value="" required autocomplete="usuario" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="privilegios"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Especialidad:') }}</label>
                                <div class="col-md-6">
                                    <input id="usuario" type="text"
                                        class="form-control @error('usuario') is-invalid @enderror" name="usuario"
                                        value="{{ old('usuario') }}" required autocomplete="usuario" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="estado"
                                class="col-md-4 col-form-label text-md-right">{{ __('Estado:') }}</label>

                            <div class="col-md-6">
                                <select id="estado" class="form-control @error('estado') is-invalid @enderror"
                                    name="estado" required>
                                    <option value="1"{{ old('estado') === 'Activo' ? ' selected' : '' }}>Activo
                                    </option>
                                    <option value="0"{{ old('estado') === 'Inactivo' ? ' selected' : '' }}>Inactivo
                                    </option>

                                </select>

                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Contraseña:') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña:') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                    class="	far fa-window-close"></i> Cancelar</button>
                            <button id="usercreate" type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                {{ __(' Registrar') }}
                            </button>
                        </div>
                    </form>


                </div>

            </div>
        </div>
    </div>


@section('js')
    <script>
        function mostrarMiniFormulario() {
            const seleccion = document.getElementById("seleccion").value;
            const miniFormulario = document.getElementById("miniFormulario");

            if (seleccion === "Doctor") {
                miniFormulario.style.display = "block";
            } else {
                miniFormulario.style.display = "none";
            }
        }
    </script>
    <script>
        const userModalBtn = document.getElementById("userModalBtn");
        const createUserModal = document.getElementById("createUserModal");
        const closeModal = document.getElementById("closeModal");

        userModalBtn.addEventListener("click", () => {
            createUserModal.style.display = "block";
        });

        closeModal.addEventListener("click", () => {
            createUserModal.style.display = "none";
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Activar la pestaña "Crear Producto"
            function showAlert(icon, title, text) {
                // Mostrar el mensaje de éxito
                Swal.fire({
                    imageUrl: 'vendor/adminlte/dist/img/dent.png',
                    imageHeight: 100,
                    imageAlt: 'A tall image',
                    title: title,
                    text: text,
                    showConfirmButton: true,
                    allowOutsideClick: false,
                });
            }

            @if (session('successC'))
                // Mostrar mensaje de éxito para la creación
                showAlert('success', 'Éxito', '{{ session('successC') }}');
            @elseif (session('errorC'))
                // Mostrar mensaje de error para la creación
                showAlert('error', 'Error', '{{ session('errorC') }}');
                $(document).ready(function() {
                    $('#createUserModal').modal('show');
                });
            @endif

            @if (session('success'))
                // Mostrar mensaje de éxito para la actualización
                showAlert('success', 'Éxito', '{{ session('success') }}');
            @elseif (session('error'))
                // Mostrar mensaje de error para la actualización
                showAlert('error', 'Error', '{{ session('error') }}');
                @foreach ($users as $user)
                    @if (session('error_id') == $user->id)
                        $(document).ready(function() {
                            $('#editUserModal{{ $user->id }}').modal('show');
                        });
                    @endif
                @endforeach
            @endif
        });

        function previewImage(event) {
            const input = event.target;
            const imagePreview = document.getElementById('photoPreview');


            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                imagePreview.style.display = 'none';
            }
        }

        $(document).ready(function() {
            $('#userTable').DataTable({
                "language": {
                    "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json', // Ruta al archivo de idioma en español
                },
                responsive: "true",
                dom: 'Bfrtilp',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"> Exportar a Excel</i>',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"> Exportar a PDF</i>',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"> Imprimir Tabla</i>',
                        className: 'btn btn-info'
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


@stop
@endsection