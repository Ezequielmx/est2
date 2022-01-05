<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Livewire\ShowEventos;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function () {
    return view('admin.index');
})->name('admin');

Route::middleware(['auth:sanctum', 'verified'])->get('/admin/mensajes', function () {
    return view('admin.mensajes.index');
})->name('adminmens');

Route::middleware(['auth:sanctum', 'verified'])->get('/admin/nuevareserva', function () {
    return view('admin.nuevareserva.index');
})->name('nuevareserva');


Route::get('/', ShowEventos::class)->name('home');

Route::get('/{id_event}', [EventoController::class, 'show'])->name('evento.show');


