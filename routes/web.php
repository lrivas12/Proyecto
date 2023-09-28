<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::resource('/usuario', (UsuarioController::class));
Route::resource('/categoria', (categoriaController::class));
Route::resource('/proveedores', (ProveedoresController::class));
Route::resource('/cliente', (clienteController::class));
Route::resource('/producto', (ProductoController::class));
Route::post('usuario/{id}/', [UsuarioController::class, 'DesactivarUsuario'])->name('usuario.desactivate');
//usuario.store
//provedores.update
//Route::get(usuario/{id}, [UsuarioController::class], 'DesactivarUsuario'])->name('usuario.Desactivar');
//  php artisan route:list -v