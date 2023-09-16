@extends('adminlte::page')
@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)


@section('title', 'Panel de Control')

@section('content_header')
    <h1>Panel de Control</h1>
@stop

@section('content')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('footer')
<h5 class="text-center ">Derechos Reservados © 2023 | Creado por Techno Advanced</h5>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="{{ asset('path/to/sweetalert2.min.js') }}"></script>
@stop