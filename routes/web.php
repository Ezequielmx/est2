<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SheetController;
use App\Http\Livewire\ShowEvento;
use App\Http\Livewire\ShowEventos;
use App\Http\Livewire\TestMap;

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
    return view('admin');
})->name('admin');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Route::get('/', HomeController::class)->name('home');




Route::get('/', ShowEventos::class)->name('home');

Route::get('/maps', TestMap::class);

Route::get('/test', function () {return view('test');});

Route::get('/admin', [AdminController::class, 'index'])->name('admin');

/*Route::get('/reserva/{id_event}', [ReservaController::class, 'create'])->name('reserva.create');*/

/*Route::post('reservas', [ReservaController::class, 'store'])->name('reserva.store');*/

Route::get('/{id_event}', [EventoController::class, 'show'])->name('evento.show');



