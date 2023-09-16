@extends('layouts.index')

@section('title', 'Usuarios')

@section('css')
    <style>
        .modal {
            display: none;
        }
    </style>

@stop

@section('content_header')
    <h1>Usuarios</h1>
    <hr class="my-2" />
@stop


@section('content')

    <div class="container">
        <div class="container">
            <br>
            <a id="userModalBtn" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal"
                data-whatever="@mdo">Crear
                Usuario</a><br><br>
            <div class="row justify-content-center card">
                <div class="col-md-15x">
                    <div class="card-body">
                        <h3>Listado de Usuarios</h3>
                        <div>
                            <table id="userTable" class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Id</th>
                                        <th>Foto</th>
                                        <th>Usuario</th>
                                        <th>Nombres y Apellidos</th>
                                        <th>Correo Electrónico</th>
                                        <th>Rol</th>
                                        <th>Telefono</th>
                                        <th>Estado</th>
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
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->nombreusuario }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->rolusuario }}</td>
                                    <td>{{ $user->telefonousuario }}</td>
                                    <td>{{ $user->estadousuario }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#editUserModal{{ $user->id }}">
                                            <i class="fas fa-edit"></i>Editar
                                        </button>

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

                                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel{{ $user->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        Editar Usuario</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
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
                                                                        name="fotousuario" id="fotousuario" accept="image/*"
                                                                        onchange="previewImage(event)">
                                                                    <br>
                                                                </div>

                                                                @error('fotousuario')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="nombreusuario"
                                                                class="col-md-4 col-form-label text-md-right">{{ __('Nombre y Apellido:') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="nombreusuario" type="text"
                                                                    class="form-control @error('nombreusuario') is-invalid @enderror"
                                                                    name="nombreusuario"
                                                                    value="{{ old('nombreusuario', $user->nombreusuario) }}" required
                                                                    autocomplete="nombreusuario" autofocus>

                                                                @error('nombreusuario')
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
                                                                <input id="username" type="text"
                                                                    class="form-control @error('username') is-invalid @enderror"
                                                                    name="username"
                                                                    value="{{ old('username', $user->username) }}" required
                                                                    autocomplete="username" autofocus>
                                                                @error('username')
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
                                                            <label for="telefonousuario"
                                                                class="col-md-4 col-form-label text-md-right">{{ __('Teléfono:') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="telefonousuario" type="text"
                                                                    class="form-control @error('telefonousuario') is-invalid @enderror"
                                                                    name="telefonousuario" value="{{ old('telefonousuario', $user->telefonousuario) }}"
                                                                    required autocomplete="telefonousuario">

                                                                @error('telefonousuario')
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
                                                                <select id="rolusuario"
                                                                    class="form-control @error('privilegios') is-invalid @enderror"
                                                                    name="rolusuario" required autocomplete="rolusuario">
                                                                    <option
                                                                        value="Administrador"{{ old('rolusuario', $user->rolusuario) === 'Administrador' ? ' selected' : '' }}>
                                                                        Administrador</option>
                                                                    <option
                                                                        value="Editor"{{ old('rolusuario', $user->rolusuario) === 'Editor' ? ' selected' : '' }}>
                                                                        Editor</option>
                                                                    </select>

                                                                @error('rolusuario')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label for="estado"
                                                                class="col-md-4 col-form-label text-md-right">{{ __('Estado:') }}</label>

                                                            <div class="col-md-6">
                                                                <select id="estado"
                                                                    class="form-control @error('estadousuario') is-invalid @enderror"
                                                                    name="estadousuario" required autocomplete="estadousuario">
                                                                    <option
                                                                        value="Activo"{{ old('estadousuario', $user->estado) === 'Activo' ? ' selected' : '' }}>
                                                                        Activo</option>
                                                                    <option
                                                                        value="Inactivo"{{ old('estadousuario', $user->estado) === 'Inactivo' ? ' selected' : '' }}>
                                                                        Inactivo</option>
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
                                                                <input id="password-confirm" type="password"
                                                                    class="form-control" name="password_confirmation"
                                                                    autocomplete="new-password">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button id="usereditado" type="submit"
                                                                class="btn btn-primary">
                                                                {{ __('Actualizar') }}
                                                            </button>
                                                        </div>
                                                </div>
                                                </form>

                                            </div>

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
    </div>
    </div>


    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Usuario</h5>
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
                                    name="fotousuario" id="fotousuario" accept="image/*" onchange="previewImage(event)">
                                <br>
                                @error('fotousuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombreusuario"
                                class="col-md-4 col-form-label text-md-right">{{ __('Nombre Y Apellido:') }}</label>

                            <div class="col-md-6">
                                <input id="nombreusuario" type="text"
                                    class="form-control @error('nombreusuario') is-invalid @enderror" name="nombreusuario"
                                    value="{{ old('nombreusuario') }}" required autocomplete="nombreusuario" autofocus>

                                @error('nombreusuario')
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
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
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
                            <label for="telefonousuario"
                                class="col-md-4 col-form-label text-md-right">{{ __('Teléfono:') }}</label>

                            <div class="col-md-6">
                                <input id="telefonousuario" type="text"
                                    class="form-control @error('telefonousuario') is-invalid @enderror" name="telefonousuario"
                                    value="{{ old('telefonousuario') }}" required autocomplete="telefonousuario">

                                @error('telefonousuario')
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
                                <select id="rolusuario" class="form-control @error('rolusuario') is-invalid @enderror"
                                    name="rolusuario" required>
                                    <option
                                        value="Administrador"{{ old('rolusuario') === 'Administrador' ? ' selected' : '' }}>
                                        Administrador
                                    </option>
                                    <option value="Editor"{{ old('rolusuario') === 'Editor' ? ' selected' : '' }}>
                                        Editor</option>
                                    
                                </select>

                                @error('rolusuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>



                        <div class="form-group row">
                            <label for="estado"
                                class="col-md-4 col-form-label text-md-right">{{ __('Estado:') }}</label>

                            <div class="col-md-6">
                                <select id="estado" class="form-control @error('estadousuario') is-invalid @enderror"
                                    name="estadousuario" required>
                                    <option value="Activo"{{ old('estadousuario') === 'Activo' ? ' selected' : '' }}>Activo
                                    </option>
                                    <option value="Inactivo"{{ old('estadousuario') === 'Inactivo' ? ' selected' : '' }}>Inactivo
                                    </option>

                                </select>

                                @error('estadousuario')
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button id="usercreate" type="submit" class="btn btn-primary">
                                {{ __('Registrar') }}
                            </button>
                        </div>
                    </form>


                </div>

            </div>
        </div>
    </div>
    </div>






@endsection

@section('js')
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
                }
            });
        });
    </script>


@endsection