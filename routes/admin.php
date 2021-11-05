<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GeneraleController;


//Route::get('/', [AdminController::class], 'index');

Route::resource('admin', AdminController::class);

Route::resource('generales', GeneraleController::class)->names('admin.generales');